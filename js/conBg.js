//-------------------
//  背景图相关
//-------------------
(function () {
	var BG = document.getElementById('BG');
	var imgHeight = 1080;
	var imgWidth = 1386;
	var imgRatio = imgWidth / imgHeight;

	function getSeenRatio() {
		var seenHeight = window.innerHeight;
		var seenWidth = window.innerWidth;
		var seenRatio = seenWidth / seenHeight;
		return seenRatio;
	}

	function bgScroll() {
		// 手机上不滚动
		if (document.body.getAttribute('ismobile') == 'true')
			return;
		var scrollTop = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
		var seenWidth = window.innerWidth;
		var seenHeight = window.innerHeight;
		var allHeight = document.body.scrollHeight;
		var maxTop = (BG.offsetHeight != 0 ? BG.offsetHeight : (seenWidth / imgWidth * imgHeight)) - seenHeight;
		//console.log(scrollTop, seenHeight, allHeight, maxTop);
		// 错误强制修复
		(function () {
			var nowTop = -parseInt(BG.style.top.replace(/px$/g, ''));
			if (nowTop > maxTop || nowTop < -BG.offsetHeight) {
				BG.style.top = '0px';
			}
		})();
		// 只在横屏时滚动
		if (getSeenRatio() > 1) {
			if (allHeight != seenHeight) {
				var newTop = ((scrollTop / (allHeight - seenHeight)) * 1.6 * maxTop);
				BG.style.top = '-' + (newTop < maxTop ? newTop : maxTop) + 'px';
			} else {
				BG.style.top = -maxTop + 'px';
			}
		} else
			BG.style.top = '0px';
	}

	function bgResize() {
		var seenHeight = window.innerHeight;
		var seenWidth = window.innerWidth;
		var seenRatio = seenWidth / seenHeight;

		// 可视宽高比 <= 图像宽高比, 高度优先
		// 可视宽高比 >  图像宽高比, 宽度优先
		if (seenRatio <= imgRatio) {
			BG.style.height = '100vh';
			BG.style.width = 'unset';
		} else {
			BG.style.height = 'unset';
			BG.style.width = '100vw';
		}

		BG.style.display = "block";
		BG.onload = function() {
			BG.style.opacity = "0.7";
		}
		setTimeout(function () {
			BG.style.opacity = "0.7";
		}, 2000);
		bgScroll();
	}

	window.addEventListener('scroll', bgScroll);
	window.addEventListener('resize', bgResize);

	bgResize();
	setInterval(function () {
		bgResize();
	}, 2000);
})();
