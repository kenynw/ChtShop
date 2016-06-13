wx.ready(function () {
  document.querySelector('#checkJsApi').onclick = function () {
    wx.checkJsApi({
      jsApiList: [
        'onMenuShareTimeline',
        'onMenuShareAppMessage'
      ],
      success: function (res) {
        alert(JSON.stringify(res));
      }
    });
  };
  document.querySelector('#onMenuShareAppMessage').onclick = function () {
    wx.onMenuShareAppMessage({
      title: '分享到好友',
      desc: '分享到好友',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
      trigger: function (res) {
        alert('分享到好友。');
      },
      success: function (res) {
        alert('分享到好友成功');
      },
      cancel: function (res) {
        alert('分享到好友取消');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
    alert('??????');
  };

  document.querySelector('#onMenuShareTimeline').onclick = function () {
    wx.onMenuShareTimeline({
      title: '分享到朋友圈',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
      trigger: function (res) {
        alert('分享到朋友圈。');
      },
      success: function (res) {
        alert('分享到朋友圈成功');
      },
      cancel: function (res) {
        alert('分享到朋友圈取消');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
    alert('？？？？？？？');
  };

  var shareData = {
    title: 'JS-SDK Demo',
    desc: 'JS-SDK Demo',
    link: 'http://demo.open.weixin.qq.com/jssdk/',
    imgUrl: 'http://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRt8Qia4lv7k3M9J1SKqKCImxJCt7j9rHYicKDI45jRPBxdzdyREWnk0ia0N5TMnMfth7SdxtzMvVgXg/0'
  };
  wx.onMenuShareAppMessage(shareData);
  wx.onMenuShareTimeline(shareData);
});

wx.error(function (res) {
  alert(res.errMsg);
});
