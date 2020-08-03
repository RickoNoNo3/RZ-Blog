# [POJ-1260](http://poj.org/problem?id=1260)
# 题目分析
题目比较复杂, 简述一下大意:

有几种不同等级的珠宝, 每种珠宝都有不同的价值. 每买一种珠宝, 需要额外支付该种珠宝单价的十倍. 现在对每种珠宝有不同的采购颗数需求, 但高级珠宝可以顶替低级珠宝的颗数需求. 求出最小的花费.

这道题依然动态规划:

# 代码(C++)
```
#include <iostream>
#include <algorithm>
#define INF 1e9
using namespace std;
int main(){
	int T;
	cin >> T;
	while(T--){
		int n, m[105], v[105], dp[105], cnt[105];
		dp[0] = 0;
		cin >> n;
		for(int i = 1; i <= n; i++){
			cin >> m[i] >> v[i];
			cnt[i] = cnt[i-1] + m[i];
		}
		for(int i = 1; i <= n; i++){
			dp[i] = dp[i-1] + (m[i] + 10) * v[i];
			for(int j = 0; j < i; j++){
				dp[i] = min(dp[i], (cnt[i] - cnt[j] + 10) * v[i] + dp[j]);
			}
		}
		cout << dp[n] << endl;
	}
	return 0;
}
```
