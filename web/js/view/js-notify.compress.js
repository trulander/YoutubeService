!function(o,i,n){var t=function(i,n){if(o.Notification)if("default"===Notification.permission)Notification.requestPermission(function(){i&&t(i,n)});else{if("granted"===Notification.permission){if(!i)return;opt=n||{},opt.tag=function(){function o(){return Math.floor(65536*(1+Math.random())).toString(16).substring(1)}return o()+o()+"-"+o()+"-"+o()+"-"+o()+"-"+o()+o()+o()}();var e=new Notification(i,opt);return e.onclick=function(){opt.onclick&&opt.onclick(this),this.close()},e.onclose=function(){opt.onclose&&opt.onclose(this)},e}"denied"===Notification.permission&&n&&n.ondenied&&n.ondenied(this)}};"object"==typeof module&&module&&"object"==typeof module.exports?module.exports=t:(o.notify=t,"function"==typeof define&&define.amd&&define("notify",[],function(){return t}))}(window,document);