# [HDU-2602](http://acm.hdu.edu.cn/showproblem.php?pid=2602)
# 题目分析
经典的01背包问题. 

# 转移方程
<latex>
\begin{align}
dp[i][j] = \begin{cases}
           0,                                       &i = 0 || j = 0\\
           dp[i-1][j],                              &j \lt w[i]\\
           max(dp[i-1][j], dp[i-1][j-w[i]] + v[i]), &其他
           \end{cases}
\end{align}
</latex>

# 代码(C++)

这里使用了滚动数组

```
#include <cstdio>
#include <algorithm>
using namespace std;

int main() {
	int T, N, V;
	scanf("%d", &T);
	while(T--) {
		int value[1005], volumn[1005], dp[1005] = {0};
		scanf("%d%d", &N, &V);
		for(int i = 1; i <= N; ++i)
			scanf("%d", &value[i]);
		for(int i = 1; i <= N; ++i)
			scanf("%d", &volumn[i]);

		for(int i = 1; i <= N; ++i)
			for(int j = V; j >= volumn[i]; --j)
				dp[j] = max(dp[j], dp[j - volumn[i]] + value[i]);
		printf("%d\n", dp[V]);
	}
}

```
