/**
 * Timeago is a jQuery plugin that makes it easy to support automatically
 * updating fuzzy timestamps (e.g. "4 minutes ago" or "about 1 day ago").
 *
 * @name timeago
 * @version 1.6.7
 * @requires jQuery >=1.5.0 <4.0
 * @author Ryan McGeary
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 * For usage and examples, visit:
 * http://timeago.yarp.com/
 *
 * Copyright (c) 2008-2019, Ryan McGeary (ryan -[at]- mcgeary [*dot*] org)
 */
!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&"object"==typeof module.exports?t(require("jquery")):t(jQuery)}(function(l){l.timeago=function(t){return t instanceof Date?o(t):o("string"==typeof t?l.timeago.parse(t):"number"==typeof t?new Date(t):l.timeago.datetime(t))};var i=l.timeago;l.extend(l.timeago,{settings:{refreshMillis:6e4,allowPast:!0,allowFuture:!1,localeTitle:!1,cutoff:0,autoDispose:!0,strings:{prefixAgo:null,prefixFromNow:null,suffixAgo:"ago",suffixFromNow:"from now",inPast:"any moment now",seconds:"less than a minute",minute:"about a minute",minutes:"%d minutes",hour:"about an hour",hours:"about %d hours",day:"a day",days:"%d days",month:"about a month",months:"%d months",year:"about a year",years:"%d years",wordSeparator:" ",numbers:[]}},inWords:function(i){if(!this.settings.allowPast&&!this.settings.allowFuture)throw"timeago allowPast and allowFuture settings can not both be set to false.";var a=this.settings.strings,t=a.prefixAgo,e=a.suffixAgo;if(this.settings.allowFuture&&i<0&&(t=a.prefixFromNow,e=a.suffixFromNow),!this.settings.allowPast&&0<=i)return this.settings.strings.inPast;var n=Math.abs(i)/1e3,o=n/60,r=o/60,s=r/24,u=s/365;function m(t,e){t=l.isFunction(t)?t(e,i):t,e=a.numbers&&a.numbers[e]||e;return t.replace(/%d/i,e)}s=n<45&&m(a.seconds,Math.round(n))||n<90&&m(a.minute,1)||o<45&&m(a.minutes,Math.round(o))||o<90&&m(a.hour,1)||r<24&&m(a.hours,Math.round(r))||r<42&&m(a.day,1)||s<30&&m(a.days,Math.round(s))||s<45&&m(a.month,1)||s<365&&m(a.months,Math.round(s/30))||u<1.5&&m(a.year,1)||m(a.years,Math.round(u)),u=a.wordSeparator||"";return void 0===a.wordSeparator&&(u=" "),l.trim([t,s,e].join(u))},parse:function(t){t=l.trim(t);return t=(t=(t=(t=(t=t.replace(/\.\d+/,"")).replace(/-/,"/").replace(/-/,"/")).replace(/T/," ").replace(/Z/," UTC")).replace(/([\+\-]\d\d)\:?(\d\d)/," $1$2")).replace(/([\+\-]\d\d)$/," $100"),new Date(t)},datetime:function(t){t=i.isTime(t)?l(t).attr("datetime"):l(t).attr("title");return i.parse(t)},isTime:function(t){return"time"===l(t).get(0).tagName.toLowerCase()}});var a={init:function(){a.dispose.call(this);var t=l.proxy(n,this);t();var e=i.settings;0<e.refreshMillis&&(this._timeagoInterval=setInterval(t,e.refreshMillis))},update:function(t){t=t instanceof Date?t:i.parse(t);l(this).data("timeago",{datetime:t}),i.settings.localeTitle&&l(this).attr("title",t.toLocaleString()),n.apply(this)},updateFromDOM:function(){l(this).data("timeago",{datetime:i.parse(i.isTime(this)?l(this).attr("datetime"):l(this).attr("title"))}),n.apply(this)},dispose:function(){this._timeagoInterval&&(window.clearInterval(this._timeagoInterval),this._timeagoInterval=null)}};function n(){var t=i.settings;if(t.autoDispose&&!l.contains(document.documentElement,this))return l(this).timeago("dispose"),this;var e=function(t){{var e;(t=l(t)).data("timeago")||(t.data("timeago",{datetime:i.datetime(t)}),e=l.trim(t.text()),i.settings.localeTitle?t.attr("title",t.data("timeago").datetime.toLocaleString()):!(0<e.length)||i.isTime(t)&&t.attr("title")||t.attr("title",e))}return t.data("timeago")}(this);return isNaN(e.datetime)||(0===t.cutoff||Math.abs(r(e.datetime))<t.cutoff?l(this).text(o(e.datetime)):0<l(this).attr("title").length&&l(this).text(l(this).attr("title"))),this}function o(t){return i.inWords(r(t))}function r(t){return(new Date).getTime()-t.getTime()}l.fn.timeago=function(t,e){var i=t?a[t]:a.init;if(!i)throw new Error("Unknown function name '"+t+"' for timeago");return this.each(function(){i.call(this,e)}),this},document.createElement("abbr"),document.createElement("time")});