# [POJ-1159](http://poj.org/problem?id=1159)
# 题目分析
判断一个字符串形成回文串最少需要添加的字符数. 此题有两种方法, 复杂度都为\\(O(n^{2})\\)

# 方法1: 对自身做LCS
## 思路
1. 拷贝一个字符串翻转后的副本.
2. 对字符串与其副本做LCS算法, 可得LCS长度.
3. 使用字符串长度 - LCS长度, 即可得到需要添加的字符数.

其实在这里, 如果题目变成"最少需要删除的字符数", 答案依然如此, 不会变化. 这是因为这种方法的本质是求出了**不相同的字符数**, 而每一次添加/删除操作必然与每一个不相同的字符一一对应.

但是需要注意, 如果题目又变成"替换", 就不可以类比了. 例如"123456", 添加/删除的最优解为5, 而替换的最优解为3. 有关更复杂题目的解题思路, 详见我的另一篇文章《最小回文代价》

## 代码(C++)
```
#include <algorithm>
#include <string>
#include <iostream>
#include <cstring>
using namespace std;
int main() {
	int n;
	cin >> n;
	string str;
	cin >> str;
	short *tdp = new short[5005 * 5005];
	#define dp(x,y) *(tdp+(x)*(str2.size()+1)+(y))
	memset(tdp, 0, 5005 * 5005 * sizeof(short));
	for (int i = 1; i <= n; ++i) {
		for (int j = n; j >= i; ++j) {
			if (str1[i-1] == str2[j-1])
				dp(i, j) = dp(i-1, j-1) + 1;
			else
				dp(i, j) = max(dp(i, j-1), dp(i-1, j));
		}
	}
	cout << n - dp(n, n) << endl;
}
```
# 方法2: 另一种DP思路(本质依然是LCS)
## 转移方程

<latex display="none">
\begin{align}
&&dp[i] &= 0,                                &i = 0 \
&&dp[i] &= min(match(i, t), dp[i-1] + 1),    &1 \le i \le 字符串长度, t \in 词典
\end{align}
</latex>


