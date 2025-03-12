(() => {
    "use strict";
    var n = {
            9: (n, e, t) => {
                t.d(e, {
                    Z: () => a
                });
                var o = t(645),
                    r = t.n(o)()((function(n) {
                        return n[1]
                    }));
                r.push([n.id, "div {max-width:100% !important;} \n .iframe {\n  position: relative;\n  width: 100%;\n  height: 100%;\n}\n\n.iframe_iframe {\n  width: 100%;\n  height: 100%;\n  background: #ffffff;\n  vertical-align: bottom;\n}\n\n.iframe_loader {\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  z-index: 1;\n  background: #ffffff;\n}\n\n.iframe_loader.is_hidden {\n  display: none;\n}\n\n@keyframes skeleton-loading {\n  0% {\n    background-color: #eaebea;\n  }\n  100% {\n    background-color: #cccccc;\n  }\n}\n\n.skl_box {\n  border-radius: 4px;\n  animation: skeleton-loading 0.5s linear infinite alternate;\n}\n\n.skl {\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  display: flex;\n  flex-direction: column;\n  background: #ffffff;\n}\n\n.skl_top {\n  flex: 1;\n  padding: 24px;\n}\n\n.skl_bottom {\n  padding: 24px;\n}\n\n.skl_logo {\n  width: 200px;\n  height: 40px;\n  margin: 0 auto 20px;\n}\n\n.skl_freq {\n  width: 100%;\n  height: 42px;\n  margin-bottom: 12px;\n}\n\n.skl_label {\n  width: 200px;\n  height: 24px;\n  margin: 0 auto 8px;\n}\n\n.skl_amount {\n  gap: 8px;\n  display: flex;\n  flex-wrap: wrap;\n  margin-bottom: 8px;\n}\n\n.skl_amount-btn {\n  flex: 1;\n  height: 42px;\n}\n\n.skl_donate-btn {\n  width: 100%;\n  height: 76px;\n}\n", ""]);
                const a = r
            },
            100: (n, e, t) => {
                t.d(e, {
                    Z: () => a
                });
                var o = t(645),
                    r = t.n(o)()((function(n) {
                        return n[1]
                    }));
                r.push([n.id, ".egiframe {\n  position: relative;\n  overflow: hidden;\n  height: 100%;\n}\n\n@media screen and (min-width: 480px) {\n  .egiframe {\n    max-width: 100%;\n  }\n}\n\n.egiframe .iframe {\n  position: absolute;\n  top: 0;\n  bottom: 0;\n  left: 0;\n  right: 0;\n}\n\n.egiframe_faq_toggle {\n  text-align: center;\n  cursor: pointer;\n  border-width: 0;\n  font-size: 0.85em;\n  background: transparent;\n  color: rgba(0, 0, 0, 0.6);\n}\n\n.egiframe_faq_toggle .arrow {\n  width: 0;\n  height: 0;\n  margin-left: 4px;\n  display: inline-block;\n  vertical-align: middle;\n  border-left: 5px solid transparent;\n  border-right: 5px solid transparent;\n\n  border-bottom: 5px solid rgba(0, 0, 0, 0.6);\n}\n\n.egiframe_faq_toggle.is_faq_open .arrow {\n  border-bottom-width: 0;\n  border-top: 5px solid rgba(0, 0, 0, 0.6);\n}\n", ""]);
                const a = r
            },
            751: (n, e, t) => {
                t.d(e, {
                    Z: () => a
                });
                var o = t(645),
                    r = t.n(o)()((function(n) {
                        return n[1]
                    }));
                r.push([n.id, "*,\n*::after,\n*::before {\n  color: #2c343b;\n  box-sizing: border-box;\n  font: normal 16px/1.5 sans-serif;\n}\n\n.eginline {\n  max-width: 100%;\n  text-align: center;\n}\n\n.eginline_body {\n  max-width: 100%;\n}\n\n.eginline_footer {\n  padding: 4px;\n  margin-top: -1px;\n  background-color: #fff;\n}\n\n.eginline_poweredBy {\n  height: 40px;\n  font-size: 12px;\n  line-height: 40px;\n  padding-left: 24px;\n  padding-right: 24px;\n  background: white;\n  color: #00000099;\n  text-align: center;\n  font-family: sans-serif;\n}\n", ""]);
                const a = r
            },
            289: (n, e, t) => {
                t.d(e, {
                    Z: () => a
                });
                var o = t(645),
                    r = t.n(o)()((function(n) {
                        return n[1]
                    }));
                r.push([n.id, ".modal {\n  overflow: hidden;\n  position: fixed;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  z-index: 10000;\n  display: flex;\n  justify-content: flex-start;\n  opacity: 0;\n\n  /* Disable click events while the modal is closed */\n  pointer-events: none;\n\n  /* Disable tab navigation while the modal is closed */\n  visibility: hidden;\n}\n\n@media screen and (min-width: 480px) {\n  .modal {\n    display: flex;\n    padding-top: 32px;\n    padding-bottom: 32px;\n    align-items: center;\n    justify-content: center;\n  }\n}\n\n.modal * {\n  pointer-events: none;\n}\n\n.modal.is_open {\n  opacity: 1;\n\n  /* Enable click events while the modal is closed */\n  pointer-events: auto;\n\n  /* Enable tab navigation while the modal is closed */\n  visibility: visible;\n}\n\n.modal.is_open * {\n  pointer-events: auto;\n}\n\n.modal_backdrop {\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  background: rgba(0, 0, 0, 0.65);\n}\n\n.modal_content {\n  display: flex;\n  flex-direction: column;\n  padding-top: 44px;\n  padding-bottom: 40px;\n  position: relative;\n  max-width: 100%;\n  z-index: 10001;\n  margin: 0 auto;\n  will-change: transform, opacity;\n  transition: transform 0.07s cubic-bezier(0.465, 0.183, 0.153, 0.946),\n    opacity 0.07s cubic-bezier(0.465, 0.183, 0.153, 0.946);\n  transform: scale(1.15);\n}\n\n.modal.is_open .modal_content {\n  transform: scale(1);\n}\n\n.modal_body {\n  flex: 1;\n}\n\n.modal_footer {\n  padding: 4px;\n  background: white;\n}\n\n.modal_poweredBy {\n  color: #1b1918;\n  position: absolute;\n  text-align: center;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  height: 40px;\n  font-size: 12px;\n  line-height: 40px;\n  padding-left: 24px;\n  padding-right: 24px;\n  background: white;\n  font-family: sans-serif;\n  border-top: 1px solid #f3f2f2;\n}\n\n.modal_poweredBy svg {\n  display: none;\n  margin-right: 4px;\n  vertical-align: middle;\n}\n\n@media screen and (min-width: 480px) {\n  .modal_footer {\n    border-bottom-left-radius: 20px;\n    border-bottom-right-radius: 20px;\n  }\n\n  .modal_content {\n    padding-bottom: 24px;\n  }\n\n  .modal_poweredBy {\n    color: white;\n    text-align: left;\n    font-weight: lighter;\n    border-top-width: 0;\n    background: black;\n  }\n\n  .modal_poweredBy svg {\n    display: inline-block;\n  }\n}\n\n.modal_closebtn {\n  top: 8px;\n  padding: 0;\n  right: 16px;\n  z-index: 10003;\n  font-size: 24px;\n  line-height: 1;\n  cursor: pointer;\n  border-width: 0;\n  position: absolute;\n  font-weight: lighter;\n  background: transparent;\n  color: white;\n}\n", ""]);
                const a = r
            },
            394: (n, e, t) => {
                t.d(e, {
                    Z: () => a
                });
                var o = t(645),
                    r = t.n(o)()((function(n) {
                        return n[1]
                    }));
                r.push([n.id, "*,\n*::after,\n*::before {\n  color: #2c343b;\n  box-sizing: border-box;\n  font: normal 16px/1.5 sans-serif;\n}\n\n.egmodal .modal_footer {\n  margin-top: -1px;\n  text-align: center;\n}\n\n.egmodal .egiframe {\n  width: 100vw;\n  z-index: 10002;\n}\n\n.egmodal .iframe_loader {\n  z-index: 10001;\n}\n\n@media screen and (min-width: 480px) {\n  .egmodal .egiframe {\n    width: 420px;\n    height: 592px;\n    max-height: calc(100vh - 84px);\n    border-top-left-radius: 20px;\n    border-top-right-radius: 20px;\n  }\n}\n", ""]);
                const a = r
            },
            981: (n, e, t) => {
                t.d(e, {
                    Z: () => a
                });
                var o = t(645),
                    r = t.n(o)()((function(n) {
                        return n[1]
                    }));
                r.push([n.id, ".egmodals {\n  position: relative;\n  z-index: 2147483645;\n}\n", ""]);
                const a = r
            },
            868: (n, e, t) => {
                t.d(e, {
                    Z: () => a
                });
                var o = t(645),
                    r = t.n(o)()((function(n) {
                        return n[1]
                    }));
                r.push([n.id, ".egnudgetray {\n  gap: 16px;\n  width: 100%;\n  display: none;\n  margin-top: 24px;\n  padding: 12px 16px;\n  border-radius: 8px;\n  position: relative;\n  align-items: center;\n  background: #ffffff;\n  color: #444444;\n  box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);\n}\n\n.egnudgetray.is_open {\n  display: flex;\n}\n\n.egnudgetray_body {\n  flex: 1;\n}\n\n.egnudgetray_title {\n  font-weight: bold;\n}\n\n.egnudgetray_content {\n  font-size: 14px;\n}\n\n.egnudgetray_ctabtn {\n  border: none;\n  color: #ffffff;\n  cursor: pointer;\n  font-size: 14px;\n  padding: 8px 16px;\n  border-radius: 8px;\n}\n\n.egnudgetray_closebtn {\n  position: absolute;\n  padding: 0;\n  top: -16px;\n  right: -16px;\n  border: none;\n  cursor: pointer;\n  color: #444444;\n  background: #ffffff;\n  width: 32px;\n  height: 32px;\n  font-size: 18px;\n  font-weight: lighter;\n  border-radius: 32px;\n  box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);\n}\n", ""]);
                const a = r
            },
            637: (n, e, t) => {
                t.d(e, {
                    Z: () => a
                });
                var o = t(645),
                    r = t.n(o)()((function(n) {
                        return n[1]
                    }));
                r.push([n.id, ".egnudgetrays {\n  position: fixed;\n  right: 24px;\n  bottom: 24px;\n  width: 420px;\n  z-index: 2147483644;\n  max-width: calc(100% - 48px);\n}\n", ""]);
                const a = r
            },
            645: n => {
                n.exports = function(n) {
                    var e = [];
                    return e.toString = function() {
                        return this.map((function(e) {
                            var t = n(e);
                            return e[2] ? "@media ".concat(e[2], " {").concat(t, "}") : t
                        })).join("")
                    }, e.i = function(n, t, o) {
                        "string" == typeof n && (n = [
                            [null, n, ""]
                        ]);
                        var r = {};
                        if (o)
                            for (var a = 0; a < this.length; a++) {
                                var i = this[a][0];
                                null != i && (r[i] = !0)
                            }
                        for (var s = 0; s < n.length; s++) {
                            var c = [].concat(n[s]);
                            o && r[c[0]] || (t && (c[2] ? c[2] = "".concat(t, " and ").concat(c[2]) : c[2] = t), e.push(c))
                        }
                    }, e
                }
            },
            996: n => {
                var e = function(n) {
                        return function(n) {
                            return !!n && "object" == typeof n
                        }(n) && ! function(n) {
                            var e = Object.prototype.toString.call(n);
                            return "[object RegExp]" === e || "[object Date]" === e || function(n) {
                                return n.$$typeof === t
                            }(n)
                        }(n)
                    },
                    t = "function" == typeof Symbol && Symbol.for ? Symbol.for("react.element") : 60103;

                function o(n, e) {
                    return !1 !== e.clone && e.isMergeableObject(n) ? s((t = n, Array.isArray(t) ? [] : {}), n, e) : n;
                    var t
                }

                function r(n, e, t) {
                    return n.concat(e).map((function(n) {
                        return o(n, t)
                    }))
                }

                function a(n) {
                    return Object.keys(n).concat(function(n) {
                        return Object.getOwnPropertySymbols ? Object.getOwnPropertySymbols(n).filter((function(e) {
                            return n.propertyIsEnumerable(e)
                        })) : []
                    }(n))
                }

                function i(n, e) {
                    try {
                        return e in n
                    } catch (n) {
                        return !1
                    }
                }

                function s(n, t, c) {
                    (c = c || {}).arrayMerge = c.arrayMerge || r, c.isMergeableObject = c.isMergeableObject || e, c.cloneUnlessOtherwiseSpecified = o;
                    var l = Array.isArray(t);
                    return l === Array.isArray(n) ? l ? c.arrayMerge(n, t, c) : function(n, e, t) {
                        var r = {};
                        return t.isMergeableObject(n) && a(n).forEach((function(e) {
                            r[e] = o(n[e], t)
                        })), a(e).forEach((function(a) {
                            (function(n, e) {
                                return i(n, e) && !(Object.hasOwnProperty.call(n, e) && Object.propertyIsEnumerable.call(n, e))
                            })(n, a) || (i(n, a) && t.isMergeableObject(e[a]) ? r[a] = function(n, e) {
                                if (!e.customMerge) return s;
                                var t = e.customMerge(n);
                                return "function" == typeof t ? t : s
                            }(a, t)(n[a], e[a], t) : r[a] = o(e[a], t))
                        })), r
                    }(n, t, c) : o(t, c)
                }
                s.all = function(n, e) {
                    if (!Array.isArray(n)) throw new Error("first argument should be an array");
                    return n.reduce((function(n, t) {
                        return s(n, t, e)
                    }), {})
                };
                var c = s;
                n.exports = c
            }
        },
        e = {};

    function t(o) {
        var r = e[o];
        if (void 0 !== r) return r.exports;
        var a = e[o] = {
            id: o,
            exports: {}
        };
        return n[o](a, a.exports, t), a.exports
    }
    t.n = n => {
        var e = n && n.__esModule ? () => n.default : () => n;
        return t.d(e, {
            a: e
        }), e
    }, t.d = (n, e) => {
        for (var o in e) t.o(e, o) && !t.o(n, o) && Object.defineProperty(n, o, {
            enumerable: !0,
            get: e[o]
        })
    }, t.o = (n, e) => Object.prototype.hasOwnProperty.call(n, e), (() => {
        var n = t(996),
            e = t.n(n),
            o = function() {
                return (o = Object.assign || function(n) {
                    for (var e, t = 1, o = arguments.length; t < o; t++)
                        for (var r in e = arguments[t]) Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
                    return n
                }).apply(this, arguments)
            },
            r = ["amount", "currency", "preset1", "preset2", "preset3", "preset4", "designation", "recurring", "c_src", "c_src2", "first", "last", "email", "zip"],
            a = function(n) {
                return n.campaigns.reduce((function(n, e) {
                    return n[e.campaignId] = {
                        donation: {}
                    }, n
                }), {})
            },
            i = function() {
                var n = new URLSearchParams(location.search);
                return r.reduce((function(e, t) {
                    var r, a = n.get(t);
                    return null === a ? e : o(o({}, e), ((r = {})[t] = a, r))
                }), {})
            };
        const s = function() {
            function n(n) {
                var e = this;
                this.isInViewport = function(n) {
                    var t = e.el.getBoundingClientRect();
                    return t.top < window.innerHeight - n && t.bottom > n
                }, this.makeEl = function() {
                    return e._el = document.createElement("div"), e._el.className = e.elClass, e._el.appendChild(e.makeStyle()), e._el
                }, this.makeStyle = function() {
                    var n = document.createElement("style");
                    return n.innerHTML = e.styles, n
                }, this.elClass = n
            }
            return Object.defineProperty(n.prototype, "el", {
                get: function() {
                    return this._el ? this._el : this.makeEl()
                },
                enumerable: !1,
                configurable: !0
            }), n
        }();
        var c = t(868);
        const l = function() {
            function n() {
                var n = this;
                this.publish = function(e) {
                    var t = n.subscriptions[e.eventName];
                    t && Object.keys(t).forEach((function(n) {
                        t[n](e)
                    }))
                }, this.subscribe = function(e, t) {
                    n.subscriptions[e] || (n.subscriptions[e] = {});
                    var o = n.generateNextKey();
                    return n.subscriptions[e][o] = t, e + "." + o
                }, this.generateNextKey = function() {
                    var e = n.currentKey + 1;
                    return n.currentKey = e, e
                }, this.currentKey = 0, this.subscriptions = {}
            }
            return n.prototype.unsubscribe = function(n) {
                var e = n.split("."),
                    t = e[0],
                    o = e[1];
                return !!this.subscriptions[t][o] && (delete this.subscriptions[t][o], !0)
            }, n
        }();
        var p, d = (p = function(n, e) {
                return (p = Object.setPrototypeOf || {
                        __proto__: []
                    }
                    instanceof Array && function(n, e) {
                        n.__proto__ = e
                    } || function(n, e) {
                        for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                    })(n, e)
            }, function(n, e) {
                if ("function" != typeof e && null !== e) throw new TypeError("Class extends value " + String(e) + " is not a constructor or null");

                function t() {
                    this.constructor = n
                }
                p(n, e), n.prototype = null === e ? Object.create(e) : (t.prototype = e.prototype, new t)
            }),
            u = "is_open",
            f = "open",
            m = "close",
            g = "closeclick",
            h = "ctaclick";
        const v = function(n) {
            function e(e) {
                var t = n.call(this, "egnudgetray") || this;
                return t.styles = c.Z.toString(), t.open = function() {
                    t.state.isOpen || (t.state.isOpen = !0, t.el.classList.add(u), t.pubsub.publish({
                        eventName: f,
                        details: {}
                    }))
                }, t.close = function() {
                    t.state.isOpen && (t.state.isOpen = !1, t.el.classList.remove(u), t.pubsub.publish({
                        eventName: m,
                        details: {}
                    }))
                }, t.onOpen = function(n) {
                    return t.pubsub.subscribe(f, n)
                }, t.onClose = function(n) {
                    return t.pubsub.subscribe(m, n)
                }, t.onCtaClick = function(n) {
                    return t.pubsub.subscribe(h, n)
                }, t.onCloseClick = function(n) {
                    return t.pubsub.subscribe(g, n)
                }, t.makeCloseBtn = function() {
                    var n = document.createElement("button");
                    return n.className = t.elClass + "_closebtn", n.setAttribute("aria-label", "Close the nudge tray"), n.setAttribute("data-id", "eg-nudgetray-close"), n.innerHTML = "&times;", n.addEventListener("click", (function() {
                        t.close(), t.pubsub.publish({
                            eventName: g,
                            details: {}
                        })
                    })), n
                }, t.off = function(n) {
                    return t.pubsub.unsubscribe(n)
                }, t.makeBody = function() {
                    var n = document.createElement("div");
                    return n.className = t.elClass + "_body", n.appendChild(t.makeTitle()), n.appendChild(t.makeContent()), n
                }, t.makeTitle = function() {
                    var n = t.props.title,
                        e = document.createElement("div");
                    if (e.className = t.elClass + "_title", !n) return e;
                    var o = n.length > 20 ? n.substring(0, 20).concat("...") : n;
                    return e.textContent = o, e.title = n, e
                }, t.makeContent = function() {
                    var n = document.createElement("div");
                    return n.className = t.elClass + "_content", n.textContent = t.props.content, n
                }, t.makeCtaBtn = function() {
                    var n = document.createElement("button");
                    return n.className = t.elClass + "_ctabtn", n.setAttribute("data-id", "eg-nudgetray-click"), n.textContent = t.props.ctaLabel, n.style.backgroundColor = t.props.ctaColor, n.addEventListener("click", (function() {
                        t.pubsub.publish({
                            eventName: h,
                            details: {}
                        }), t.close()
                    })), n
                }, t.props = e, t.state = {
                    isOpen: !1
                }, t.pubsub = new l, t.el.appendChild(t.makeCloseBtn()), t.el.appendChild(t.makeBody()), t.el.appendChild(t.makeCtaBtn()), t
            }
            return d(e, n), e
        }(s);
        var b = t(637),
            y = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }();
        const w = function(n) {
            function e(e) {
                var t = n.call(this, "egnudgetrays") || this;
                return t.styles = b.Z.toString(), t.makeSDK = function() {
                    var n = a(t.props.config);
                    return t.props.config.campaigns.forEach((function(e) {
                        var o = e.campaignId,
                            r = e.donation;
                        r.nudgeTrays && (n[o].donation.nudgeTrays = r.nudgeTrays.map(t.makeNudgeTray))
                    })), n
                }, t.makeNudgeTray = function(n) {
                    var e = new v({
                        title: n.title,
                        content: n.content,
                        ctaLabel: n.ctaLabel,
                        ctaColor: n.ctaColor
                    });
                    return t.el.appendChild(e.el), {
                        open: e.open,
                        close: e.close,
                        onOpen: e.onClose,
                        onClose: e.onClose,
                        onCtaClick: e.onCtaClick,
                        onCloseClick: e.onCloseClick,
                        off: e.off
                    }
                }, t.props = e, t.el.setAttribute("data-testid", "egnudgetrays"), t.sdk = t.makeSDK(), t
            }
            return y(e, n), e
        }(s);
        var k = function(n) {
                var e = this;
                this.getCampaignStatus = function(n) {
                    return t = e, o = void 0, a = function() {
                        var e, t, o;
                        return function(n, e) {
                            var t, o, r, a, i = {
                                label: 0,
                                sent: function() {
                                    if (1 & r[0]) throw r[1];
                                    return r[1]
                                },
                                trys: [],
                                ops: []
                            };
                            return a = {
                                next: s(0),
                                throw: s(1),
                                return: s(2)
                            }, "function" == typeof Symbol && (a[Symbol.iterator] = function() {
                                return this
                            }), a;

                            function s(a) {
                                return function(s) {
                                    return function(a) {
                                        if (t) throw new TypeError("Generator is already executing.");
                                        for (; i;) try {
                                            if (t = 1, o && (r = 2 & a[0] ? o.return : a[0] ? o.throw || ((r = o.return) && r.call(o), 0) : o.next) && !(r = r.call(o, a[1])).done) return r;
                                            switch (o = 0, r && (a = [2 & a[0], r.value]), a[0]) {
                                                case 0:
                                                case 1:
                                                    r = a;
                                                    break;
                                                case 4:
                                                    return i.label++, {
                                                        value: a[1],
                                                        done: !1
                                                    };
                                                case 5:
                                                    i.label++, o = a[1], a = [0];
                                                    continue;
                                                case 7:
                                                    a = i.ops.pop(), i.trys.pop();
                                                    continue;
                                                default:
                                                    if (!((r = (r = i.trys).length > 0 && r[r.length - 1]) || 6 !== a[0] && 2 !== a[0])) {
                                                        i = 0;
                                                        continue
                                                    }
                                                    if (3 === a[0] && (!r || a[1] > r[0] && a[1] < r[3])) {
                                                        i.label = a[1];
                                                        break
                                                    }
                                                    if (6 === a[0] && i.label < r[1]) {
                                                        i.label = r[1], r = a;
                                                        break
                                                    }
                                                    if (r && i.label < r[2]) {
                                                        i.label = r[2], i.ops.push(a);
                                                        break
                                                    }
                                                    r[2] && i.ops.pop(), i.trys.pop();
                                                    continue
                                            }
                                            a = e.call(n, i)
                                        } catch (n) {
                                            a = [6, n], o = 0
                                        } finally {
                                            t = r = 0
                                        }
                                        if (5 & a[0]) throw a[1];
                                        return {
                                            value: a[0] ? a[1] : void 0,
                                            done: !0
                                        }
                                    }([a, s])
                                }
                            }
                        }(this, (function(r) {
                            switch (r.label) {
                                case 0:
                                    e = void 0, t = this.props.env.baseUrl + "/frs-api/campaign/" + n + "/eg-status", r.label = 1;
                                case 1:
                                    return r.trys.push([1, 4, , 5]), [4, fetch(t)];
                                case 2:
                                    return [4, r.sent().json()];
                                case 3:
                                    return o = r.sent(), e = {
                                        url: o.canonical_url,
                                        name: o.name,
                                        isEmbed: "disabled" !== o.embedded_giving,
                                        isPublished: "active" === o.status
                                    }, [3, 5];
                                case 4:
                                    return r.sent(), e = void 0, [3, 5];
                                case 5:
                                    return [2, e]
                            }
                        }))
                    }, new((r = void 0) || (r = Promise))((function(n, e) {
                        function i(n) {
                            try {
                                c(a.next(n))
                            } catch (n) {
                                e(n)
                            }
                        }

                        function s(n) {
                            try {
                                c(a.throw(n))
                            } catch (n) {
                                e(n)
                            }
                        }

                        function c(e) {
                            var t;
                            e.done ? n(e.value) : (t = e.value, t instanceof r ? t : new r((function(n) {
                                n(t)
                            }))).then(i, s)
                        }
                        c((a = a.apply(t, o || [])).next())
                    }));
                    var t, o, r, a
                }, this.props = n
            },
            _ = t(394),
            C = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }();
        const x = function(n) {
            function e(e) {
                var t = n.call(this, "egmodal") || this;
                return t.styles = _.Z.toString(), t.open = function() {
                    t.state.hasLoaded ? t.props.modal.open() : t.loadAndOpen(), t.props.iframe.trackEvent("embedded-giving:modal:track-event:open")
                }, t.loadAndOpen = function() {
                    t.loadModal(), window.requestAnimationFrame(t.props.modal.open)
                }, t.loadModal = function() {
                    t.state.hasLoaded || (t.state.hasLoaded = !0, t.el.appendChild(t.props.modal.el))
                }, t.close = function() {
                    t.props.modal.close()
                }, t.on = function(n, e) {
                    return t.props.modal.on(n, e)
                }, t.off = function(n) {
                    return t.props.modal.off(n)
                }, t.props = e, t.state = {
                    hasLoaded: !1
                }, e.lazyLoad || t.loadModal(), t.onReady = t.props.onReady, t
            }
            return C(e, n), e
        }(s);

        function O(n, e, t, o, r) {
            var a, i, s = r ? "#:~:tcm-prompt=Hidden&log=*" : "";
            return "" + function(n, e) {
                return n + "/give/" + e + "/#!/donation/checkout"
            }(o && "" !== o ? (i = "https://", -1 !== (a = o).indexOf(i) ? a : "" + (i + a)) : n, e) + function(n) {
                var e = new URLSearchParams;
                Object.keys(n).forEach((function(t) {
                    return e.set(t, n[t])
                }));
                var t = e.toString();
                return t ? "?" + t : ""
            }(t) + s
        }
        var E = t(981),
            S = t(9),
            P = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }(),
            j = "is_hidden";
        const A = function(n) {
            function e(e) {
                var t = n.call(this, "iframe") || this;
                t.styles = S.Z.toString(), t.updateProps = function(n) {
                    t.props = n, t.iframe.setAttribute("src", n.src)
                }, t.postMessage = function(n) {
                    t.state.hasLoaded ? t.iframe.contentWindow && t.iframe.contentWindow.postMessage(n, "*") : t.state.messageQueue.push(n)
                }, t.makeLoader = function() {
                    var n = document.createElement("div"),
                        e = t.elClass + "_loader";
                    return n.className = e, n.setAttribute("data-testid", e), n.innerHTML = t.makeSkl(), n
                }, t.makeSkl = function() {
                    return '\n    <div class="skl">\n      <div class="skl_top">\n        <div class="skl_logo skl_box"></div>\n        <div class="skl_freq skl_box"></div>\n        <div class="skl_label skl_box"></div>\n        <div class="skl_amount">\n          <div class="skl_amount-btn skl_box"></div>\n          <div class="skl_amount-btn skl_box"></div>\n        </div>\n        <div class="skl_amount">\n          <div class="skl_amount-btn skl_box"></div>\n          <div class="skl_amount-btn skl_box"></div>\n        </div>\n        <div class="skl_amount">\n          <div class="skl_amount-btn skl_box"></div>\n        </div>\n      </div>\n      <div class="skl_bottom">\n        <div class="skl_label skl_box"></div>\n        <div class="skl_donate-btn skl_box"></div>\n      </div>\n    </div>\n  '
                }, t.makeIframe = function() {
                    var n = document.createElement("iframe"),
                        e = t.elClass + "_iframe";
                    return n.className = e, n.setAttribute("src", t.props.src), n.setAttribute("data-testid", e), n.setAttribute("frameBorder", "0"), n.setAttribute("allow", "payment"), n.setAttribute("allowfullscreen", "true"), n.setAttribute("allowpaymentrequest", "true"), n.addEventListener("load", (function() {
                        t.loader.classList.contains(j) || t.loader.classList.add(j)
                    })), n
                }, t.props = e, t.state = {
                    hasLoaded: !1,
                    messageQueue: []
                }, t.iframe = t.makeIframe(), t.loader = t.makeLoader(), t.el.appendChild(t.iframe), t.el.appendChild(t.loader);
                var o = function(n) {
                    "embedded-giving:iframe:loaded" === n.data && (window.removeEventListener("message", o), t.state.hasLoaded = !0, t.state.messageQueue.forEach((function(n) {
                        t.postMessage(n)
                    })))
                };
                return window.addEventListener("message", o), t
            }
            return P(e, n), e
        }(s);
        var L = t(100),
            M = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }(),
            I = "is_faq_open",
            T = "eg-faq-open";
        const D = function(n) {
            function e(e) {
                var t = n.call(this, "egiframe") || this;
                return t.styles = L.Z.toString(), t.makeIframe = function() {
                    t.iframe = new A({
                        src: t.props.iframeSrc
                    }), t.iframe.el.classList.add(t.elClass + "_iframe"), t.el.appendChild(t.iframe.el)
                }, t.trackEvent = function(n) {
                    t.iframe.postMessage(n)
                }, t.navigate = function(n) {
                    t.iframe.postMessage("embedded-giving:navigate:" + n)
                }, t.setDonation = function(n) {
                    var e = Object.keys(n).map((function(e) {
                        return e + "=" + n[e]
                    })).join("&");
                    t.iframe.postMessage("embedded-giving:donation:set?" + e.toString())
                }, t.resetDonation = function() {
                    t.iframe.postMessage("embedded-giving:donation:reset")
                }, t.makeFAQToggle = function() {
                    var n = document.createElement("button"),
                        e = document.createTextNode("FAQs");
                    n.appendChild(e);
                    var o = document.createElement("span");
                    return o.className = "arrow", n.appendChild(o), n.className = t.elClass + "_faq_toggle", n.setAttribute("data-id", T), n.addEventListener("click", t.toggleFAQ), n
                }, t.isFAQOpen = function() {
                    return t.el.classList.contains(I)
                }, t.toggleFAQ = function() {
                    t.isFAQOpen() ? t.closeFAQ() : t.openFAQ()
                }, t.closeFAQ = function() {
                    t.el.classList.remove(I), t.faqToggle.classList.remove(I), t.faqToggle.setAttribute("data-id", T), t.iframe.postMessage("embedded-giving:navigate:faq:close")
                }, t.openFAQ = function() {
                    t.el.classList.add(I), t.faqToggle.classList.add(I), t.faqToggle.setAttribute("data-id", "eg-faq-close"), t.iframe.postMessage("embedded-giving:navigate:faq")
                }, t.props = e, t.makeIframe(), t.faqToggle = t.makeFAQToggle(), t
            }
            return M(e, n), e
        }(s);
        var N = t(289),
            B = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }(),
            F = "is_open",
            z = "keydown";
        const q = function(n) {
            function e(e) {
                var t = n.call(this, "modal") || this;
                return t.styles = N.Z.toString(), t.open = function() {
                    t.state.isOpen || (t.state.isOpen = !0, t.el.classList.add(F), t.pubsub.publish({
                        eventName: "open",
                        details: {}
                    }), document.body.addEventListener(z, t.onEscKeydown))
                }, t.close = function() {
                    t.state.isOpen && (t.state.isOpen = !1, t.el.classList.remove(F), t.pubsub.publish({
                        eventName: "close",
                        details: {}
                    }), document.body.removeEventListener(z, t.onEscKeydown))
                }, t.on = function(n, e) {
                    return t.pubsub.subscribe(n, e)
                }, t.off = function(n) {
                    return t.pubsub.unsubscribe(n)
                }, t.onEscKeydown = function(n) {
                    "Escape" !== n.key && "Esc" !== n.key || t.props.onClose()
                }, t.makeBackdrop = function() {
                    var n = document.createElement("div");
                    return n.className = t.elClass + "_backdrop", n.setAttribute("data-testid", "backdrop"), n.addEventListener("click", t.props.onClose), n
                }, t.makeContent = function() {
                    var n = document.createElement("div"),
                        e = t.elClass + "_content";
                    return n.className = e, n.appendChild(t.makeCloseBtn()), n.appendChild(t.makeBody()), t.props.footer && n.appendChild(t.makeFooter()), n
                }, t.makeBody = function() {
                    var n = document.createElement("main");
                    return n.className = t.elClass + "_body", n.appendChild(t.props.body), n
                }, t.makeFooter = function() {
                    var n = document.createElement("footer");
                    return n.className = t.elClass + "_footer", t.props.footer && n.appendChild(t.props.footer), n
                }, t.makePoweredBy = function() {
                    var n = document.createElement("div");
                    return n.className = t.elClass + "_poweredBy", n.innerHTML = '\n      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">\n        <path\n          fill="#DAAD0D" \n          d="M9.69593 6.16702C9.63727 6.07973 9.5333 6.03618 9.43021 6.05637L6.21434 6.67598L6.86731 0.37508C6.87978 0.255304 6.809 0.143255 6.69537 0.102861C6.58157 0.0626431 6.45617 0.104793 6.39014 0.205602L0.284533 9.52707C0.226928 9.61489 0.227455 9.72799 0.285938 9.81492C0.343894 9.90151 0.447864 9.94524 0.551658 9.92592L3.7677 9.30614L3.11473 15.6069C3.10226 15.727 3.17304 15.839 3.28667 15.8793C3.31459 15.8891 3.34392 15.8942 3.37378 15.8942C3.46194 15.8942 3.54326 15.8501 3.59173 15.7765L9.69733 6.45504C9.75494 6.36723 9.75423 6.25413 9.69593 6.16702Z"\n        />\n      </svg> Powered by Classy from GoFundMe\n    ', n
                }, t.makeCloseBtn = function() {
                    var n = document.createElement("button");
                    return n.className = t.elClass + "_closebtn", n.setAttribute("aria-label", "Close the donation modal"), n.innerHTML = "&times;", n.addEventListener("click", t.props.onClose), n
                }, t.props = e, t.state = {
                    isOpen: !1
                }, t.pubsub = new l, t.el.setAttribute("role", "dialog"), t.el.setAttribute("data-modal", "true"), t.el.setAttribute("data-label", "Donation Modal"), t.el.appendChild(t.makeBackdrop()), t.el.appendChild(t.makeContent()), t.el.appendChild(t.makePoweredBy()), t
            }
            return B(e, n), e
        }(s);
        var U = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }(),
            K = function() {
                return (K = Object.assign || function(n) {
                    for (var e, t = 1, o = arguments.length; t < o; t++)
                        for (var r in e = arguments[t]) Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
                    return n
                }).apply(this, arguments)
            };
        const R = function(n) {
            function e(e) {
                var t = n.call(this, "egmodals") || this;
                return t.styles = E.Z.toString(), t.makeSDK = function() {
                    var n = a(t.props.config);
                    return t.props.config.campaigns.forEach((function(e) {
                        var o = e.campaignId,
                            r = e.donation,
                            a = e.customDomain,
                            i = e.disableCookieDialog;
                        r.modal && (n[o].donation.modal = t.makeModal(o, r.modal, a, i))
                    })), n
                }, t.makeModal = function(n, e, o, r) {
                    var a = t.makeModalProps(n, e, o, r),
                        i = new x(a);
                    return t.el.appendChild(i.el), {
                        on: i.on,
                        off: i.off,
                        open: i.open,
                        close: i.close,
                        navigate: a.iframe.navigate,
                        trackEvent: a.iframe.trackEvent,
                        resetDonation: a.iframe.resetDonation,
                        setDonation: a.iframe.setDonation,
                        config: function(i) {
                            var s = K(K({}, e), i);
                            a.iframe.iframe.updateProps({
                                src: t.makeIframeSrc(n, s, o, r)
                            })
                        },
                        onReady: i.onReady
                    }
                }, t.makeModalProps = function(n, e, o, r) {
                    var a = t.makeIframeSrc(n, e, o, r),
                        i = new D({
                            iframeSrc: a,
                            version: t.props.config.version
                        });
                    i.iframe.iframe.setAttribute("name", "eg-popup-iframe--" + n);
                    var s = new q({
                        body: i.el,
                        footer: i.faqToggle,
                        onClose: function() {
                            i.isFAQOpen() ? i.toggleFAQ() : s.close()
                        }
                    });
                    return {
                        iframe: i,
                        modal: s,
                        lazyLoad: e.lazyLoad,
                        iframeSrc: a,
                        onReady: function(o) {
                            return r = t, a = void 0, s = function() {
                                var t, r;
                                return function(n, e) {
                                    var t, o, r, a, i = {
                                        label: 0,
                                        sent: function() {
                                            if (1 & r[0]) throw r[1];
                                            return r[1]
                                        },
                                        trys: [],
                                        ops: []
                                    };
                                    return a = {
                                        next: s(0),
                                        throw: s(1),
                                        return: s(2)
                                    }, "function" == typeof Symbol && (a[Symbol.iterator] = function() {
                                        return this
                                    }), a;

                                    function s(a) {
                                        return function(s) {
                                            return function(a) {
                                                if (t) throw new TypeError("Generator is already executing.");
                                                for (; i;) try {
                                                    if (t = 1, o && (r = 2 & a[0] ? o.return : a[0] ? o.throw || ((r = o.return) && r.call(o), 0) : o.next) && !(r = r.call(o, a[1])).done) return r;
                                                    switch (o = 0, r && (a = [2 & a[0], r.value]), a[0]) {
                                                        case 0:
                                                        case 1:
                                                            r = a;
                                                            break;
                                                        case 4:
                                                            return i.label++, {
                                                                value: a[1],
                                                                done: !1
                                                            };
                                                        case 5:
                                                            i.label++, o = a[1], a = [0];
                                                            continue;
                                                        case 7:
                                                            a = i.ops.pop(), i.trys.pop();
                                                            continue;
                                                        default:
                                                            if (!((r = (r = i.trys).length > 0 && r[r.length - 1]) || 6 !== a[0] && 2 !== a[0])) {
                                                                i = 0;
                                                                continue
                                                            }
                                                            if (3 === a[0] && (!r || a[1] > r[0] && a[1] < r[3])) {
                                                                i.label = a[1];
                                                                break
                                                            }
                                                            if (6 === a[0] && i.label < r[1]) {
                                                                i.label = r[1], r = a;
                                                                break
                                                            }
                                                            if (r && i.label < r[2]) {
                                                                i.label = r[2], i.ops.push(a);
                                                                break
                                                            }
                                                            r[2] && i.ops.pop(), i.trys.pop();
                                                            continue
                                                    }
                                                    a = e.call(n, i)
                                                } catch (n) {
                                                    a = [6, n], o = 0
                                                } finally {
                                                    t = r = 0
                                                }
                                                if (5 & a[0]) throw a[1];
                                                return {
                                                    value: a[0] ? a[1] : void 0,
                                                    done: !0
                                                }
                                            }([a, s])
                                        }
                                    }
                                }(this, (function(a) {
                                    switch (a.label) {
                                        case 0:
                                            return (t = e.onError) ? [4, this.dalService.getCampaignStatus(n)] : [3, 2];
                                        case 1:
                                            return (r = a.sent()) ? r.isPublished ? r.isEmbed ? o() : t({
                                                type: "NOT_EMBED",
                                                url: r.url,
                                                name: r.name
                                            }) : t({
                                                type: "NOT_PUBLISHED",
                                                url: r.url,
                                                name: r.name
                                            }) : t({
                                                type: "NOT_EXISTS"
                                            }), [3, 3];
                                        case 2:
                                            o(), a.label = 3;
                                        case 3:
                                            return [2]
                                    }
                                }))
                            }, new((i = void 0) || (i = Promise))((function(n, e) {
                                function t(n) {
                                    try {
                                        c(s.next(n))
                                    } catch (n) {
                                        e(n)
                                    }
                                }

                                function o(n) {
                                    try {
                                        c(s.throw(n))
                                    } catch (n) {
                                        e(n)
                                    }
                                }

                                function c(e) {
                                    var r;
                                    e.done ? n(e.value) : (r = e.value, r instanceof i ? r : new i((function(n) {
                                        n(r)
                                    }))).then(t, o)
                                }
                                c((s = s.apply(r, a || [])).next())
                            }));
                            var r, a, i, s
                        }
                    }
                }, t.makeIframeSrc = function(n, e, o, r) {
                    var a = K(K(K({}, {
                        eg: "true",
                        egp: "do",
                        renderedAs: "popup"
                    }), i()), e.urlParams);
                    return O(t.props.env.baseUrl, n, a, o, r)
                }, t.props = e, t.el.setAttribute("data-testid", "egmodals"), t.sdk = t.makeSDK(), t.dalService = new k(t.props), t
            }
            return U(e, n), e
        }(s);
        var Z = t(751),
            Q = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }();
        const H = function(n) {
            function e(e) {
                var t = n.call(this, "eginline") || this;
                return t.styles = Z.Z.toString(), t.trackEvent = function(n) {
                    t.iframe.iframe.postMessage(n)
                }, t.updateProps = function(n) {
                    t.props = n, t.iframe.iframe.updateProps({
                        src: n.iframeSrc
                    })
                }, t.onOpenEvent = function() {
                    window.addEventListener("load", t.handleOpenEvent, {
                        passive: !0
                    }), window.addEventListener("scroll", t.handleOpenEvent, {
                        passive: !0
                    })
                }, t.handleOpenEvent = function() {
                    t.isInViewport(30) && (window.removeEventListener("scroll", t.handleOpenEvent), t.trackEvent("embedded-giving:inline:track-event:open"))
                }, t.makeBody = function() {
                    var n = document.createElement("div"),
                        e = t.elClass + "_body";
                    return n.className = e, n.style.width = t.getWidth(), n.style.height = t.getHeight(), n.appendChild(t.iframe.el), n
                }, t.makeFooter = function() {
                    var n = document.createElement("div"),
                        e = t.elClass + "_footer";
                    return n.className = e, n.appendChild(t.iframe.faqToggle), n
                }, t.makePoweredBy = function() {
                    var n = document.createElement("div");
                    return n.className = t.elClass + "_poweredBy", n.innerHTML = "Powered by Classy from GoFundMe", n
                }, t.getWidth = function() {
                    return t.props.width || "420px"
                }, t.getHeight = function() {
                    return t.props.height || "592px"
                }, t.props = e, t.iframe = new D({
                    iframeSrc: t.props.iframeSrc
                }), t.el.style.width = t.getWidth(), t.el.appendChild(t.makeBody()), t.el.appendChild(t.makeFooter()), t.el.appendChild(t.makePoweredBy()), t.onOpenEvent(), t
            }
            return Q(e, n), e
        }(s);
        var W = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }(),
            G = function() {
                return (G = Object.assign || function(n) {
                    for (var e, t = 1, o = arguments.length; t < o; t++)
                        for (var r in e = arguments[t]) Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
                    return n
                }).apply(this, arguments)
            };
        const J = function(n) {
            function e(e) {
                var t = n.call(this, "egInlines") || this;
                return t.styles = "", t.makeSDK = function() {
                    var n = a(t.props.config);
                    return t.props.config.campaigns.forEach((function(e) {
                        var o = e.campaignId,
                            r = e.donation,
                            a = e.customDomain,
                            i = e.disableCookieDialog;
                        r.inline && (n[o].donation.inline = t.makeInline(o, r.inline, a, i))
                    })), n
                }, t.makeInline = function(n, e, o, r) {
                    var a = new H(t.makeInlineProps(n, e, o, r));
                    return a.iframe.iframe.iframe.setAttribute("name", "eg-inline-iframe--" + n), t.el.appendChild(a.el), {
                        getEl: function() {
                            return a.el
                        },
                        trackEvent: a.trackEvent,
                        config: function(i) {
                            var s = G(G({}, e), i);
                            a.updateProps(t.makeInlineProps(n, s, o, r))
                        }
                    }
                }, t.makeInlineProps = function(n, e, o, r) {
                    var a = G(G(G({}, e.urlParams), i()), {
                        eg: "true",
                        egp: "do",
                        renderedAs: "inline"
                    });
                    return {
                        width: e.width,
                        height: e.height,
                        iframeSrc: O(t.props.env.baseUrl, n, a, o, r)
                    }
                }, t.props = e, t.el.setAttribute("data-testid", "eginlines"), t.sdk = t.makeSDK(), t
            }
            return W(e, n), e
        }(s);
        var V = function() {
            var n = function(e, t) {
                return (n = Object.setPrototypeOf || {
                        __proto__: []
                    }
                    instanceof Array && function(n, e) {
                        n.__proto__ = e
                    } || function(n, e) {
                        for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                    })(e, t)
            };
            return function(e, t) {
                if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                function o() {
                    this.constructor = e
                }
                n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
            }
        }();
        const $ = function(n) {
            function t(t) {
                var o = n.call(this, "eg") || this;
                return o.styles = "", o.init = function() {
                    var n, t = o.props,
                        r = t.env,
                        a = t.config,
                        i = new R({
                            env: r,
                            config: a
                        }),
                        s = new w({
                            config: a
                        }),
                        c = new J({
                            env: r,
                            config: a
                        });
                    o.el.appendChild(i.el), o.el.appendChild(s.el), o.sdk = (n = [c.sdk, i.sdk, s.sdk], e().all(n))
                }, o.props = t, o.el.setAttribute("data-testid", "eg"), o.init(), o
            }
            return V(t, n), t
        }(s);
        var X = function() {
            var n = function(e, t) {
                return (n = Object.setPrototypeOf || {
                        __proto__: []
                    }
                    instanceof Array && function(n, e) {
                        n.__proto__ = e
                    } || function(n, e) {
                        for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                    })(e, t)
            };
            return function(e, t) {
                if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                function o() {
                    this.constructor = e
                }
                n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
            }
        }();
        const Y = function(n) {
            function e(e) {
                var t, o = n.call(this, "egsandbox") || this;
                return o.styles = "", o.el.attachShadow({
                    mode: "open"
                }), null === (t = o.el.shadowRoot) || void 0 === t || t.appendChild(e.children), o
            }
            return X(e, n), e
        }(s);
        var nn = function(n, e) {
                var t = {};
                for (var o in n) Object.prototype.hasOwnProperty.call(n, o) && e.indexOf(o) < 0 && (t[o] = n[o]);
                if (null != n && "function" == typeof Object.getOwnPropertySymbols) {
                    var r = 0;
                    for (o = Object.getOwnPropertySymbols(n); r < o.length; r++) e.indexOf(o[r]) < 0 && Object.prototype.propertyIsEnumerable.call(n, o[r]) && (t[o[r]] = n[o[r]])
                }
                return t
            },
            en = window,
            tn = function(n) {
                n.win.addEventListener("message", (function(e) {
                    if ("string" == typeof e.data) {
                        var t = e.data.split(n.delimitor || ":"),
                            o = t[0],
                            r = t[1],
                            a = t[2],
                            i = t[3],
                            s = t[4];
                        "embedded-giving" === o && r == n.campaignId && a === n.campaignFeature && i === n.component && n.callback(s)
                    } else e.data && "ab_testing_data" === e.data.type && (en.SC = {
                        ab_testing: e.data.ab_testing
                    })
                }))
            },
            on = ["amount", "currency", "recurring", "first", "last", "email", "zip"],
            rn = function() {
                return (rn = Object.assign || function(n) {
                    for (var e, t = 1, o = arguments.length; t < o; t++)
                        for (var r in e = arguments[t]) Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
                    return n
                }).apply(this, arguments)
            };
        const an = function(n) {
            var e = this;
            this.init = function() {
                var n = e.findModal(),
                    t = e.findNudgeTray();
                n && t && (e.modal = n, e.nudgeTray = t, e.onModalOpen(), e.onModalClose(), e.onNudgeTrayClose(), e.onNudgeTrayCtaClick(), e.onNudgeTrayCloseClick(), e.onDonationProps(), e.onDonationComplete(), e.state.hasOpenedModal && !e.state.hasCompletedDonation && (e.nudgeTray.open(), e.modal.trackEvent("embedded-giving:nudge-tray:track-event:open")))
            }, this.onModalOpen = function() {
                e.modal.on("open", (function() {
                    e.setState({
                        isModalOpen: !0,
                        hasOpenedModal: !0
                    })
                }))
            }, this.onModalClose = function() {
                e.modal.on("close", (function() {
                    e.state.hasCompletedDonation ? e.setState({
                        isModalOpen: !1,
                        hasOpenedModal: !1,
                        hasCompletedDonation: !1
                    }) : (e.nudgeTray.open(), e.modal.trackEvent("embedded-giving:nudge-tray:track-event:open"), e.setState({
                        isModalOpen: !1
                    }))
                }))
            }, this.onNudgeTrayCtaClick = function() {
                var n = e.props.campaignConfig.donation;
                e.nudgeTray.onCtaClick((function() {
                    n.modal && (e.modal.navigate("do"), e.modal.resetDonation(), e.modal.setDonation(e.state.donationProps), e.modal.open(), e.modal.trackEvent("embedded-giving:nudge-tray:track-event:click"))
                }))
            }, this.onNudgeTrayCloseClick = function() {
                var n = e.props.campaignConfig.donation;
                e.nudgeTray.onCloseClick((function() {
                    n.modal && e.modal.trackEvent("embedded-giving:nudge-tray:track-event:close")
                }))
            }, this.onNudgeTrayClose = function() {
                e.nudgeTray.onClose((function() {
                    e.removeStateCache()
                }))
            }, this.onDonationProps = function() {
                var n = e.props,
                    t = n.win,
                    o = n.campaignConfig;
                tn({
                    win: t,
                    campaignId: o.campaignId,
                    campaignFeature: "donation",
                    component: "modal",
                    callback: function(n) {
                        if (-1 !== n.indexOf("state?") && e.state.isModalOpen && !e.state.hasCompletedDonation) {
                            var t = new URLSearchParams(n.substring(5)),
                                o = {};
                            on.forEach((function(n) {
                                var e = t.get(n);
                                e && (o[n] = e)
                            })), e.setState({
                                donationProps: o
                            })
                        }
                    }
                })
            }, this.onDonationComplete = function() {
                var n = e.props,
                    t = n.win,
                    o = n.campaignConfig;
                tn({
                    win: t,
                    campaignId: o.campaignId,
                    campaignFeature: "donation",
                    component: "modal",
                    callback: function(n) {
                        "complete" === n && e.setState({
                            hasCompletedDonation: !0
                        })
                    }
                })
            }, this.findModal = function() {
                var n = e.props.campaignConfig.campaignId;
                return e.props.sdk[n].donation.modal
            }, this.findNudgeTray = function() {
                var n, t, o = e.props.campaignConfig,
                    r = o.campaignId;
                return null === (n = o.donation.nudgeTrays) || void 0 === n || n.forEach((function(n, o) {
                    if ("eg:donation:incomplete" === n.triggerEvent) {
                        var a = e.props.sdk[r].donation.nudgeTrays;
                        a && (t = a[o])
                    }
                })), t
            }, this.getInitialState = function() {
                var n = {
                        donationProps: {},
                        isModalOpen: !1,
                        hasOpenedModal: !1,
                        hasCompletedDonation: !1
                    },
                    t = e.getStateCache();
                return t ? rn(rn({}, n), t) : n
            }, this.setState = function(n) {
                e.state = rn(rn({}, e.state), n), e.state.hasCompletedDonation ? e.removeStateCache() : e.setStateCache()
            }, this.getStateCache = function() {
                var n = e.props.win,
                    t = void 0;
                if (n.localStorage) try {
                    var o = e.getStateCacheKey(),
                        r = n.localStorage.getItem(o);
                    r && (t = JSON.parse(r))
                } catch (n) {
                    console.log(n)
                }
                return t
            }, this.setStateCache = function() {
                var n = e.props.win;
                if (n.localStorage) try {
                    var t = e.getStateCacheKey(),
                        o = JSON.stringify(e.state);
                    n.localStorage.setItem(t, o)
                } catch (n) {
                    console.log(n)
                }
            }, this.removeStateCache = function() {
                var n = e.props.win;
                if (n.localStorage) try {
                    var t = e.getStateCacheKey();
                    n.localStorage.removeItem(t)
                } catch (n) {
                    console.log(n)
                }
            }, this.getStateCacheKey = function() {
                return "eg-donation-incomplete-event-handler-state-cache-" + e.props.campaignConfig.campaignId
            }, this.props = n, this.state = this.getInitialState(), this.init()
        };
        var sn = "campaign";
        const cn = function(n) {
                var e = this;
                this.bindEvents = function() {
                    e.onModalOpen(), e.onModalClose(), e.onModalButtonClick(), e.onModalCampaignIdInUrlParams()
                }, this.onModalButtonClick = function() {
                    var n = e.props,
                        t = n.win,
                        o = n.sdk,
                        a = n.campaignConfig,
                        i = a.donation.modal,
                        s = o[a.campaignId].donation.modal;
                    s && i && (s.onReady((function() {
                        t.document.body.addEventListener("click", (function(n) {
                            if (i.elementSelector && n.target.matches(i.elementSelector)) return n.preventDefault(), void s.open()
                        }))
                    })), t.document.querySelectorAll("a[href*=campaign]").forEach((function(n) {
                        n.addEventListener("click", (function(n) {
                            var e = n.currentTarget.getAttribute("href"),
                                o = new URLSearchParams(e),
                                i = o.get(sn);
                            r.some((function(n) {
                                return !!o.get(n)
                            })) || i && i === a.campaignId && (n.preventDefault(), t.history.pushState({}, "", e), s.open())
                        }))
                    })))
                }, this.onModalOpen = function() {
                    var n = e.props,
                        t = n.win,
                        o = n.sdk,
                        r = n.campaignConfig,
                        a = o[r.campaignId].donation.modal;
                    a && a.on("open", (function() {
                        e.addCampaignIdToUrlParams(t, r.campaignId)
                    }))
                }, this.onModalClose = function() {
                    var n = e.props,
                        t = n.win,
                        o = n.sdk,
                        r = n.campaignConfig,
                        a = o[r.campaignId].donation.modal;
                    a && a.on("close", (function() {
                        e.removeCampaignIdFromUrlParams(t, r.campaignId)
                    }))
                }, this.onModalCampaignIdInUrlParams = function() {
                    var n = e.props,
                        t = n.win,
                        o = n.sdk,
                        r = n.campaignConfig,
                        a = r.donation.modal,
                        i = o[r.campaignId].donation.modal;
                    i && a && e.isCampaignIdInUrlParams(t, r.campaignId) && i.open()
                }, this.isCampaignIdInUrlParams = function(n, e) {
                    var t = new URLSearchParams(n.location.search).get(sn);
                    return e && t && e === t
                }, this.addCampaignIdToUrlParams = function(n, e) {
                    var t = new URL(n.location.href);
                    t.searchParams.set(sn, e), window.history.pushState({}, "", t.href)
                }, this.removeCampaignIdFromUrlParams = function(n, e) {
                    var t = new URL(n.location.href);
                    t.searchParams.get(sn) === e && (t.searchParams.delete(sn), window.history.pushState({}, "", t.href))
                }, this.props = n, this.bindEvents()
            },
            ln = function(n) {
                var e = this;
                this.bindEvents = function() {
                    e.onModalClose(), e.onDonationComplete()
                }, this.onModalClose = function() {
                    var n = e.props.campaignConfig,
                        t = n.campaignId,
                        o = n.donation,
                        r = e.props.sdk[t].donation.modal;
                    r && r.on("close", (function() {
                        e.state.hasCompletedDonation && o.modal && (r.navigate("do"), e.state.hasCompletedDonation = !1)
                    }))
                }, this.onDonationComplete = function() {
                    var n = e.props,
                        t = n.win,
                        o = n.campaignConfig;
                    tn({
                        win: t,
                        campaignId: o.campaignId,
                        campaignFeature: "donation",
                        component: "modal",
                        callback: function(n) {
                            "complete" === n && (e.state.hasCompletedDonation = !0)
                        }
                    })
                }, this.props = n, this.state = {
                    hasCompletedDonation: !1
                }, this.bindEvents()
            },
            pn = function(n) {
                var e = this;
                this.init = function() {
                    var n = e.props,
                        t = n.win,
                        o = n.sdk,
                        r = n.campaignConfig,
                        a = r.donation.inline,
                        i = o[r.campaignId].donation.inline;
                    if (i && a) {
                        var s = t.document.querySelector(a.elementSelector);
                        if (s) {
                            var c = new Y({
                                children: i.getEl()
                            });
                            s.appendChild(c.el)
                        }
                    }
                }, this.props = n, this.init()
            };
        var dn = function(n) {
                var e = "https://www.classy.org";
                if (n) {
                    var t = new URLSearchParams(n.location.search).get("baseUrl");
                    t && (e = t)
                }
                return e
            },
            un = function() {
                var n = function(e, t) {
                    return (n = Object.setPrototypeOf || {
                            __proto__: []
                        }
                        instanceof Array && function(n, e) {
                            n.__proto__ = e
                        } || function(n, e) {
                            for (var t in e) Object.prototype.hasOwnProperty.call(e, t) && (n[t] = e[t])
                        })(e, t)
                };
                return function(e, t) {
                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

                    function o() {
                        this.constructor = e
                    }
                    n(e, t), e.prototype = null === t ? Object.create(t) : (o.prototype = t.prototype, new o)
                }
            }(),
            fn = function() {
                return (fn = Object.assign || function(n) {
                    for (var e, t = 1, o = arguments.length; t < o; t++)
                        for (var r in e = arguments[t]) Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
                    return n
                }).apply(this, arguments)
            };
        const mn = function(n) {
            function e() {
                var e = n.call(this, "egga4") || this;
                return e.styles = "", e.onPostMessage = function() {
                    window.addEventListener("message", (function(n) {
                        if (n.data) {
                            var t = n.data.key;
                            "embedded-giving:bridge:ga4:init" === t ? e.onInit(n) : "embedded-giving:bridge:ga4:event" === t && e.onEvent(n)
                        }
                    }))
                }, e.onInit = function(n) {
                    if (n.data.config) {
                        var t = n.data.config.id;
                        if (t && (e.state.id = t, !window.gtag)) {
                            var o = document.createElement("script");
                            o.setAttribute("data-eg", "true"), o.setAttribute("async", "true"), o.setAttribute("src", "https://www.googletagmanager.com/gtag/js?id=" + t), document.head.appendChild(o), window.dataLayer = window.dataLayer || [], window.gtag = function() {
                                dataLayer.push(arguments)
                            }, gtag("js", new Date), gtag("config", t, {
                                debug_mode: !0,
                                send_page_view: !1
                            })
                        }
                    }
                }, e.onEvent = function(n) {
                    if (window.gtag && e.state.id) {
                        var t = fn({
                            send_to: e.state.id
                        }, n.data.data);
                        gtag("event", n.data.event, t)
                    }
                }, e.state = {
                    id: void 0
                }, e.onPostMessage(), e
            }
            return un(e, n), e
        }(s);
        var gn, hn, vn, bn, yn, wn = function() {
            return (wn = Object.assign || function(n) {
                for (var e, t = 1, o = arguments.length; t < o; t++)
                    for (var r in e = arguments[t]) Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
                return n
            }).apply(this, arguments)
        };
        hn = function(n) {
            return {
                baseUrl: dn(n)
            }
        }(gn = window), vn = function(n) {
            var e = n.egProps;
            return e ? e.modal ? {
                campaigns: e.modal.campaigns.map((function(n) {
                    return {
                        campaignId: n.campaignId,
                        donation: {
                            modal: nn(n, ["campaignId"])
                        }
                    }
                }))
            } : e.campaigns ? {
                version: e.version,
                campaigns: e.campaigns
            } : {
                campaigns: []
            } : {
                campaigns: []
            }
        }(gn), bn = new $({
            env: hn,
            config: vn
        }), yn = new Y({
            children: bn.el
        }), document.body.appendChild(yn.el), gn.eg = bn.sdk, gn.egModal = function(n) {
            return wn({}, bn.sdk[n].donation.modal)
        }, new function(n) {
            var e = this;
            this.bindEvents = function() {
                var n = e.props,
                    t = n.win,
                    o = n.sdk;
                e.props.config.campaigns.forEach((function(n) {
                    n.donation && (new ln({
                        campaignConfig: n,
                        win: t,
                        sdk: o
                    }), new cn({
                        campaignConfig: n,
                        win: t,
                        sdk: o
                    }), new an({
                        campaignConfig: n,
                        win: t,
                        sdk: o
                    }), new pn({
                        campaignConfig: n,
                        win: t,
                        sdk: o
                    }))
                }))
            }, this.props = n, this.bindEvents()
        }({
            win: gn,
            config: vn,
            sdk: bn.sdk
        }), new mn
    })()
})();