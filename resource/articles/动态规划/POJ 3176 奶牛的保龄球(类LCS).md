# [POJ-3176](http://poj.org/problem?id=3176)
# 题目分析
又是喜闻乐见的奶牛. 这道题让我们找到给定的三角形从顶点到底边上任意一点的沿路取得的分数的最大值(令人联想起某些4399小游戏)

这个三角形长这样:
```text
    7
   3 8
  8 1 0
 2 7 4 4
4 5 2 6 5
```

乍一看是个等腰三角形, 其实可以认真分析: 从一层下降到另一层, 只能走左半格或右半格, 那么如果将当前层向左平移半格, 即可得到一个直角三角形, 同时我们人为定义每次只能走直线下方或者右斜下方, 不难发现与原图所表达的意思其实是一样的:
```text
7
3 8
8 1 0
2 7 4 4
4 5 2 6 5
```

<p>
同时经过分析得出, 对第 \(i\) 层上的第 \(j\) 个点, 其必然只能由第 \(i-1\) 层的第 \(j\) 或 \(j-1\) (如有)两个点到达, 而当前点本身的分数是确定的. 所以当前点总共可以获得的分数就会等于本身分数 + 两个来源点中总分数较大者:
</p>
<latex>
\[dp[i][j] = v[i][j] + max(dp[i-1][j], dp[i-1][j-1])\]
</latex>

其实这也是本题关键的状态转移方程的蓝图了, 相当明显, 是LCS的简易变种.

v数组中每个点对应的分数只使用一次, 且使用时dp数组相应点还没有有效数据, 因此可以将v数组作为dp数组的初始化值填入.

不难整理得到完整的转移方程

# 转移方程
<latex>
\begin{align}
&&dp[0][j] &= 0 \\
&&dp[i][0] &= 0 \\
&&dp[i][j] &= \begin{cases}
	dp[i][j] &+= &dp[i-1][j],                       & j = 1 \\
	dp[i][j] &+= &dp[i-1][j-1],                     & i = j \\
	dp[i][j] &+= &max(dp[i-1][j], dp[i-1][j-1]),    & i > j > 1
	\end{cases}
\end{align}
</latex>

仅为理论方程, 实际上可以进一步简化(见代码).

# 代码(C++)

```cpp
#include <iostream>
#include <algorithm>
#define INF 1e9
using namespace std;

int dp[400][400];
int main(){
	int n;
	cin >> n;
	for(int i = 1; i <= n; ++i)
		for(int j = 1; j <= i; ++j)
			cin >> dp[i][j];
	for(int i = 1; i <= n; i++)
		for(int j = 1; j <= i; ++j)
			dp[i][j] += max(dp[i-1][j-1], dp[i-1][j]);
	int maxn = -INF;
	for(int i = 1; i <= n; ++i)
		if(dp[n][i] > maxn)
			maxn = dp[n][i];
	cout << maxn << endl;
	return 0;
}
```
