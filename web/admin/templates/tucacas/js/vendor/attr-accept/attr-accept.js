var module = module || {};
module.exports = function (t) {
    function n(e) {
        if (r[e])return r[e].exports;
        var o = r[e] = {exports: {}, id: e, loaded: !1};
        return t[e].call(o.exports, o, o.exports, n), o.loaded = !0, o.exports
    }

    var r = {};
    return n.m = t, n.c = r, n.p = "", n(0)
}([function (t, n, r) {
    "use strict";
    n.__esModule = !0, r(8), r(9), n["default"] = function (t, n) {
        if (t && n) {
            var r = function () {
                var r = n.split(","), e = t.name || "", o = t.type || "", i = o.replace(/\/.*$/, "");
                return {
                    v: r.some(function (t) {
                        var n = t.trim();
                        return "." === n.charAt(0) ? e.toLowerCase().endsWith(n.toLowerCase()) : /\/\*$/.test(n) ? i === n.replace(/\/.*$/, "") : o === n
                    })
                }
            }();
            if ("object" == typeof r)return r.v
        }
        return !0
    }, t.exports = n["default"]
}, function (t, n) {
    var r = t.exports = {version: "1.2.2"};
    "number" == typeof __e && (__e = r)
}, function (t, n) {
    var r = t.exports = "undefined" != typeof window && window.Math == Math ? window : "undefined" != typeof self && self.Math == Math ? self : Function("return this")();
    "number" == typeof __g && (__g = r)
}, function (t, n, r) {
    var e = r(2), o = r(1), i = r(4), u = r(19), c = "prototype", f = function (t, n) {
        return function () {
            return t.apply(n, arguments)
        }
    }, s = function (t, n, r) {
        var a, p, l, d, y = t & s.G, h = t & s.P, v = y ? e : t & s.S ? e[n] || (e[n] = {}) : (e[n] || {})[c], x = y ? o : o[n] || (o[n] = {});
        y && (r = n);
        for (a in r)p = !(t & s.F) && v && a in v, l = (p ? v : r)[a], d = t & s.B && p ? f(l, e) : h && "function" == typeof l ? f(Function.call, l) : l, v && !p && u(v, a, l), x[a] != l && i(x, a, d), h && ((x[c] || (x[c] = {}))[a] = l)
    };
    e.core = o, s.F = 1, s.G = 2, s.S = 4, s.P = 8, s.B = 16, s.W = 32, t.exports = s
}, function (t, n, r) {
    var e = r(5), o = r(18);
    t.exports = r(22) ? function (t, n, r) {
        return e.setDesc(t, n, o(1, r))
    } : function (t, n, r) {
        return t[n] = r, t
    }
}, function (t, n) {
    var r = Object;
    t.exports = {
        create: r.create,
        getProto: r.getPrototypeOf,
        isEnum: {}.propertyIsEnumerable,
        getDesc: r.getOwnPropertyDescriptor,
        setDesc: r.defineProperty,
        setDescs: r.defineProperties,
        getKeys: r.keys,
        getNames: r.getOwnPropertyNames,
        getSymbols: r.getOwnPropertySymbols,
        each: [].forEach
    }
}, function (t, n) {
    var r = 0, e = Math.random();
    t.exports = function (t) {
        return "Symbol(".concat(void 0 === t ? "" : t, ")_", (++r + e).toString(36))
    }
}, function (t, n, r) {
    var e = r(20)("wks"), o = r(2).Symbol;
    t.exports = function (t) {
        return e[t] || (e[t] = o && o[t] || (o || r(6))("Symbol." + t))
    }
}, function (t, n, r) {
    r(26), t.exports = r(1).Array.some
}, function (t, n, r) {
    r(25), t.exports = r(1).String.endsWith
}, function (t, n) {
    t.exports = function (t) {
        if ("function" != typeof t)throw TypeError(t + " is not a function!");
        return t
    }
}, function (t, n) {
    var r = {}.toString;
    t.exports = function (t) {
        return r.call(t).slice(8, -1)
    }
}, function (t, n, r) {
    var e = r(10);
    t.exports = function (t, n, r) {
        if (e(t), void 0 === n)return t;
        switch (r) {
            case 1:
                return function (r) {
                    return t.call(n, r)
                };
            case 2:
                return function (r, e) {
                    return t.call(n, r, e)
                };
            case 3:
                return function (r, e, o) {
                    return t.call(n, r, e, o)
                }
        }
        return function () {
            return t.apply(n, arguments)
        }
    }
}, function (t, n) {
    t.exports = function (t) {
        if (void 0 == t)throw TypeError("Can't call method on  " + t);
        return t
    }
}, function (t, n, r) {
    t.exports = function (t) {
        var n = /./;
        try {
            "/./"[t](n)
        } catch (e) {
            try {
                return n[r(7)("match")] = !1, !"/./"[t](n)
            } catch (o) {
            }
        }
        return !0
    }
}, function (t, n) {
    t.exports = function (t) {
        try {
            return !!t()
        } catch (n) {
            return !0
        }
    }
}, function (t, n) {
    t.exports = function (t) {
        return "object" == typeof t ? null !== t : "function" == typeof t
    }
}, function (t, n, r) {
    var e = r(16), o = r(11), i = r(7)("match");
    t.exports = function (t) {
        var n;
        return e(t) && (void 0 !== (n = t[i]) ? !!n : "RegExp" == o(t))
    }
}, function (t, n) {
    t.exports = function (t, n) {
        return {enumerable: !(1 & t), configurable: !(2 & t), writable: !(4 & t), value: n}
    }
}, function (t, n, r) {
    var e = r(2), o = r(4), i = r(6)("src"), u = "toString", c = Function[u], f = ("" + c).split(u);
    r(1).inspectSource = function (t) {
        return c.call(t)
    }, (t.exports = function (t, n, r, u) {
        "function" == typeof r && (o(r, i, t[n] ? "" + t[n] : f.join(String(n))), "name"in r || (r.name = n)), t === e ? t[n] = r : (u || delete t[n], o(t, n, r))
    })(Function.prototype, u, function () {
        return "function" == typeof this && this[i] || c.call(this)
    })
}, function (t, n, r) {
    var e = r(2), o = "__core-js_shared__", i = e[o] || (e[o] = {});
    t.exports = function (t) {
        return i[t] || (i[t] = {})
    }
}, function (t, n, r) {
    var e = r(17), o = r(13);
    t.exports = function (t, n, r) {
        if (e(n))throw TypeError("String#" + r + " doesn't accept regex!");
        return String(o(t))
    }
}, function (t, n, r) {
    t.exports = !r(15)(function () {
        return 7 != Object.defineProperty({}, "a", {
                get: function () {
                    return 7
                }
            }).a
    })
}, function (t, n) {
    var r = Math.ceil, e = Math.floor;
    t.exports = function (t) {
        return isNaN(t = +t) ? 0 : (t > 0 ? e : r)(t)
    }
}, function (t, n, r) {
    var e = r(23), o = Math.min;
    t.exports = function (t) {
        return t > 0 ? o(e(t), 9007199254740991) : 0
    }
}, function (t, n, r) {
    "use strict";
    var e = r(3), o = r(24), i = r(21), u = "endsWith", c = ""[u];
    e(e.P + e.F * r(14)(u), "String", {
        endsWith: function (t) {
            var n = i(this, t, u), r = arguments, e = r.length > 1 ? r[1] : void 0, f = o(n.length), s = void 0 === e ? f : Math.min(o(e), f), a = String(t);
            return c ? c.call(n, a, s) : n.slice(s - a.length, s) === a
        }
    })
}, function (t, n, r) {
    var e = r(5), o = r(3), i = r(1).Array || Array, u = {}, c = function (t, n) {
        e.each.call(t.split(","), function (t) {
            void 0 == n && t in i ? u[t] = i[t] : t in[] && (u[t] = r(12)(Function.call, [][t], n))
        })
    };
    c("pop,reverse,shift,keys,values,entries", 1), c("indexOf,every,some,forEach,map,filter,find,findIndex,includes", 3), c("join,slice,concat,push,splice,unshift,sort,lastIndexOf,reduce,reduceRight,copyWithin,fill"), o(o.S, "Array", u)
}]);


var accept = function(file, acceptedFiles) {
    if (file && acceptedFiles) {
        const acceptedFilesArray = acceptedFiles.split(',');
        const fileName = file.name || '';
        const mimeType = file.type || '';
        const baseMimeType = mimeType.replace(/\/.*$/, '');

        return acceptedFilesArray.some(type => {
            const validType = type.trim();
            if (validType.charAt(0) === '.') {
                return fileName.toLowerCase().endsWith(validType.toLowerCase());
            } else if (/\/\*$/.test(validType)) {
                // This is something like a image/* mime type
                return baseMimeType === validType.replace(/\/.*$/, '');
            }
            return mimeType === validType;
        });
    }
    return true;
}
