# [HDU-1159](http://acm.hdu.edu.cn/showproblem.php?pid=1159) [POJ-1458](http://poj.org/problem?id=1458)
# 题目分析
经典的LCS问题.

# 情况1: 仅需要输出LCS长度
## 转移方程
<latex>
\begin{align}
dp[i][j] = \begin{cases}
           0,                                       &i = 0 || j = 0\\
           dp[i-1][j-1] + 1,                        &str1[i-1] = str2[j-1]\\
           max(dp[i-1][j], dp[i][j-1]),             &str1[i-1] \ne str2[j-1]\\
           \end{cases}
\end{align}
</latex>

## 代码(C++)

其实这里也可以用滚动数组. 会节省很多空间

```
#include <iostream>
#include <string>
#include <algorithm>
using namespace std;

int main() {
	string str1, str2;
	while(cin >> str1 >> str2) {
		short LCS[1010][1010] = {0};
		for(int i = 1; i <= str1.size(); i++)
			for(int j = 1; j <= str2.size(); j++)
				if(str1[i-1] == str2[j-1])
					LCS[i][j] = LCS[i-1][j-1] + 1;
				else
					LCS[i][j] = max(LCS[i][j-1], LCS[i-1][j]);
		cout << LCS[str1.size()][str2.size()] << endl;
	}
	return 0;
}
```

# 情况2: 要求输出一个子序列

只要理解了LCS转移方程的本质, 就也很简单, 只要从\\(dp[n][m]\\)开始, 遇到相同字符回溯左上角(当前字符为LCS内字符), 不同字符回溯上或左(必然有至少一个状态与当前状态LCS长度相等), 最终就会到达数组边界(也即LCS长度为0), 找到一条LCS的逆序列.

# 代码(C++)
```
#include <algorithm>
#include <string>
#include <iostream>
#include <cstring>
using namespace std;
int main() {
	string str1, str2;
	short *tdp = new short[2048 * 2048];
	#define dp(x,y) *(tdp+(x)*(str2.size()+1)+(y))
	while(cin >> str1 >> str2) {
		memset(tdp, 0, 2048 * 2048 * sizeof(short));
		for (int i = 1; i <= str1.size(); ++i) {
			for (int j = 1; j <= str2.size(); ++j) {
				if (str1[i-1] == str2[j-1])
					dp(i, j) = dp(i-1, j-1) + 1;
				else
					dp(i, j) = max(dp(i, j-1), dp(i-1, j));
			}
		}
	}
	int x = str1.size(), y = str2.size();
	string res;
	while (x >= 1 && y >= 1) {
		if (str1[x-1] == str2[y-1]) {
			res += str1[x-1];
			--x, --y;
		}
		else if (dp(x, y) == dp(x-1, y))
			--x;
		else
			--y;
	}
	reverse(res.begin(), res.end());
	cout << res << endl;
}
```
