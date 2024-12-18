/*
 * mustache.js - Logic-less {{mustache}} templates with JavaScript
 * http://github.com/janl/mustache.js
 */
var Mustache = (typeof module !== "undefined" && module.exports) || {};
(function(w) {
    w.name = "mustache.js";
    w.version = "0.5.0-dev";
    w.tags = ["{{", "}}"];
    w.parse = n;
    w.compile = f;
    w.render = v;
    w.clearCache = u;
    w.to_html = v;
    var t = Object.prototype.toString;
    var g = Array.isArray;
    var c = Array.prototype.forEach;
    var h = String.prototype.trim;
    var j;
    if (g) {
        j = g
    } else {
        j = function(x) {
            return t.call(x) === "[object Array]"
        }
    }
    var s;
    if (c) {
        s = function(y, z, x) {
            return c.call(y, z, x)
        }
    } else {
        s = function(A, B, z) {
            for (var y = 0, x = A.length; y < x; ++y) {
                B.call(z, A[y], y, A)
            }
        }
    }
    var k = /^\s*$/;

    function d(x) {
        return k.test(x)
    }
    var q;
    if (h) {
        q = function(x) {
            return x == null ? "" : h.call(x)
        }
    } else {
        var o, i;
        if (d("\xA0")) {
            o = /^\s+/;
            i = /\s+$/
        } else {
            o = /^[\s\xA0]+/;
            i = /[\s\xA0]+$/
        }
        q = function(x) {
            return x == null ? "" : String(x).replace(o, "").replace(i, "")
        }
    }
    var e = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;"
    };

    function p(x) {
        return String(x).replace(/&(?!\w+;)|[<>"']/g, function(y) {
            return e[y] || y
        })
    }

    function l(D, F, G, z) {
        z = z || "<template>";
        var H = F.split("\n"),
            x = Math.max(G - 3, 0),
            A = Math.min(H.length, G + 3),
            y = H.slice(x, A);
        var E;
        for (var B = 0, C = y.length; B < C; ++B) {
            E = B + x + 1;
            y[B] = (E === G ? " >> " : "    ") + y[B]
        }
        D.template = F;
        D.line = G;
        D.file = z;
        D.message = [z + ":" + G, y.join("\n"), "", D.message].join("\n");
        return D
    }

    function m(x, E) {
        var D = x.split(".");
        var B = D.length - 1;
        var C = D[B];
        var F, y, A = E.length,
            z, G;
        while (A) {
            G = E.slice(0);
            y = E[--A];
            z = 0;
            while (z < B) {
                y = y[D[z++]];
                if (y == null) {
                    break
                }
                G.push(y)
            }
            if (y && C in y) {
                F = y[C];
                break
            }
        }
        if (typeof F === "function") {
            F = F.call(G[G.length - 1])
        }
        return F == null ? "" : F
    }

    function a(B, A, D, x, y) {
        if (y) {
            if (A == null || A === false || (j(A) && A.length === 0)) {
                B(D())
            }
        } else {
            if (j(A)) {
                s(A, function(E) {
                    x.push(E);
                    B(D());
                    x.pop()
                })
            } else {
                if (typeof A === "object") {
                    x.push(A);
                    B(D());
                    x.pop()
                } else {
                    if (typeof A === "function") {
                        var z = x[x.length - 1];
                        var C = function(E) {
                            return v(E, z)
                        };
                        B(A.call(z, D(), C) || "")
                    } else {
                        if (A) {
                            B(D())
                        }
                    }
                }
            }
        }
    }

    function n(aa, C) {
        C = C || {};
        var L = C.tags || w.tags,
            M = L[0],
            H = L[L.length - 1];
        var y = ["var line = 1;", "\ntry {", '\nsend("'];
        var G = [],
            Y = false;
        var W = function() {
            if (!Y && !C.space) {
                while (G.length) {
                    y.splice(G.pop(), 1)
                }
            } else {
                G = []
            }
            Y = false
        };
        var A = function(ab) {
            return ab === "." ? "stack[stack.length - 1]" : 'find("' + ab + '")'
        };
        var T = [],
            Q, D, N;
        var V = function(ab) {
            L = q(ab).split(/\s+/);
            D = L[0];
            N = L[L.length - 1]
        };
        var K = function(ab) {
            y.push('");', Q, '\nvar partial = partials["' + q(ab) + '"];', "\nif (partial) {", "\n  send(render(partial, stack[stack.length - 1], partials));", "\n}", '\nsend("')
        };
        var x = function(ad, ab) {
            var ac = q(ad);
            if (ac === "") {
                throw l(new Error("Section name may not be empty"), aa, J, C.file)
            }
            T.push({
                name: ac,
                inverted: ab
            });
            y.push('");', Q, "\nvar value = " + A(ac) + ";", "\nvar callback = (function () {", "\n  var buffer, send = function (chunk) { buffer.push(chunk); };", "\n  return function () {", "\n    buffer = [];", '\nsend("')
        };
        var F = function(ab) {
            x(ab, true)
        };
        var U = function(ac) {
            var ab = q(ac);
            var ae = T.length != 0 && T[T.length - 1].name;
            if (!ae || ab != ae) {
                throw l(new Error('Section named "' + ab + '" was never opened'), aa, J, file)
            }
            var ad = T.pop();
            y.push('");', '\n    return buffer.join("");', "\n  };", "\n})();");
            if (ad.inverted) {
                y.push("\nsendSection(send,value,callback,stack,true);")
            } else {
                y.push("\nsendSection(send,value,callback,stack);")
            }
            y.push('\nsend("')
        };
        var X = function(ab) {
            y.push('");', Q, "\nsend(" + A(q(ab)) + ");", '\nsend("')
        };
        var z = function(ab) {
            y.push('");', Q, "\nsend(escapeHTML(" + A(q(ab)) + "));", '\nsend("')
        };
        var J = 1,
            Z, E;
        for (var R = 0, S = aa.length; R < S; ++R) {
            if (aa.slice(R, R + M.length) === M) {
                R += M.length;
                Z = aa.substr(R, 1);
                Q = "\nline = " + J + ";";
                D = M;
                N = H;
                switch (Z) {
                    case "!":
                        R++;
                        E = null;
                        break;
                    case "=":
                        R++;
                        H = "=" + H;
                        E = V;
                        break;
                    case ">":
                        R++;
                        E = K;
                        break;
                    case "#":
                        R++;
                        E = x;
                        break;
                    case "^":
                        R++;
                        E = F;
                        break;
                    case "/":
                        R++;
                        E = U;
                        break;
                    case "{":
                        H = "}" + H;
                    case "&":
                        R++;
                        Y = true;
                        E = X;
                        break;
                    default:
                        Y = true;
                        E = z
                }
                var B = aa.indexOf(H, R);
                if (B === -1) {
                    throw l(new Error('Tag "' + M + '" was not closed properly'), aa, J, C.file)
                }
                var P = aa.substring(R, B);
                if (E) {
                    E(P)
                }
                var O = 0;
                while (~(O = P.indexOf("\n", O))) {
                    J++;
                    O++
                }
                R = B + H.length - 1;
                M = D;
                H = N
            } else {
                Z = aa.substr(R, 1);
                switch (Z) {
                    case '"':
                    case "\\":
                        Y = true;
                        y.push("\\" + Z);
                        break;
                    case "\n":
                        G.push(y.length);
                        y.push("\\n");
                        W();
                        J++;
                        break;
                    default:
                        if (d(Z)) {
                            G.push(y.length)
                        } else {
                            Y = true
                        }
                        y.push(Z)
                }
            }
        }
        if (T.length != 0) {
            throw l(new Error('Section "' + T[T.length - 1].name + '" was not closed properly'), aa, J, C.file)
        }
        W();
        y.push('");', "\nsend(null);", "\n} catch (e) { throw {error: e, line: line}; }");
        var I = y.join("").replace(/send\(""\);\n/g, "");
        if (C.debug) {
            if (typeof console != "undefined" && console.log) {
                console.log(I)
            } else {
                if (typeof print === "function") {
                    print(I)
                }
            }
        }
        return I
    }

    function r(B, z) {
        var y = "view,partials,send,stack,find,escapeHTML,sendSection,render";
        var x = n(B, z);
        var A = new Function(y, x);
        return function(E, F, J) {
            if (typeof F === "function") {
                J = F;
                F = {}
            }
            F = F || {};
            var D = [];
            var H = J || function(K) {
                D.push(K)
            };
            var C = [E];
            var I = function(K) {
                return m(K, C)
            };
            try {
                A(E, F, H, C, I, p, a, v)
            } catch (G) {
                throw l(G.error, B, G.line, z.file)
            }
            return D.join("")
        }
    }
    var b = {};

    function u() {
        b = {}
    }

    function f(y, x) {
        x = x || {};
        if (x.cache !== false) {
            if (!b[y]) {
                b[y] = r(y, x)
            }
            return b[y]
        }
        return r(y, x)
    }

    function v(z, x, y, A) {
        return f(z)(x, y, A)
    }
})(Mustache);
/*
 * The New York Times Multimedia Desk.
 * Namespace: NYTD.NYTMM
 */
window.NYTD = window.NYTD || {};
window.NYTD.NYTMM = window.NYTD.NYTMM || {};
if (jQuery) {
    $j = jQuery.noConflict()
}
window.NYTD.NYTMM.namespace = function(d) {
    var c = d.split("."),
        b = NYTD.NYTMM,
        a;
    if (c[0] === "NYTD" && c[1] === "NYTMM") {
        c = c.slice(2)
    }
    for (a = 0; a < c.length; a += 1) {
        if (typeof b[c[a]] === "undefined") {
            b[c[a]] = {}
        }
        b = b[c[a]]
    }
    return b
};
window.NYTD.NYTMM.iOS = (navigator.userAgent.toLowerCase().indexOf("iphone") > -1 || navigator.userAgent.toLowerCase().indexOf("ipad") > -1);
if (NYTD.NYTMM.iOS) {
    jQuery("body").addClass("nytmm_iOS")
}
if (typeof console == "undefined") {
    window.console = {
        log: function() {},
        warn: function() {},
        error: function() {}
    }
}
window.NYTD.NYTMM.debugLevel = 1;
(function(a) {
    a.extend({
        log: function() {
            var b;
            if (arguments.length > 0) {
                b = (arguments.length > 1) ? Array.prototype.join.call(arguments, " ") : arguments[0];
                if (NYTD.NYTMM.debugLevel == 1) {
                    if (window.console) {
                        if (console.dirxml && b instanceof HTMLElement) {
                            console.dirxml(b)
                        } else {
                            if (window.console && console.log) {
                                console.log(b)
                            }
                        }
                    }
                } else {
                    if (NYTD.NYTMM.debugLevel == 2) {
                        alert(b)
                    }
                }
            }
            return b
        }
    })
})(jQuery || NYTD.jQuery);
/*
 *  Underscore.js 1.3.3
 * (c) 2009-2012 Jeremy Ashkenas, DocumentCloud Inc.
 * Underscore is freely distributable under the MIT license.
 * Portions of Underscore are inspired or borrowed from Prototype,
 * Oliver Steele's Functional, and John Resig's Micro-Templating.
 * For all details and documentation:
 * http://documentcloud.github.com/underscore
 */
(function() {
    function af(b, n, m) {
        if (b === n) {
            return 0 !== b || 1 / b == 1 / n
        }
        if (null == b || null == n) {
            return b === n
        }
        b._chain && (b = b._wrapped);
        n._chain && (n = n._wrapped);
        if (b.isEqual && ar.isFunction(b.isEqual)) {
            return b.isEqual(n)
        }
        if (n.isEqual && ar.isFunction(n.isEqual)) {
            return n.isEqual(b)
        }
        var l = an.call(b);
        if (l != an.call(n)) {
            return !1
        }
        switch (l) {
            case "[object String]":
                return b == "" + n;
            case "[object Number]":
                return b != +b ? n != +n : 0 == b ? 1 / b == 1 / n : b == +n;
            case "[object Date]":
            case "[object Boolean]":
                return +b == +n;
            case "[object RegExp]":
                return b.source == n.source && b.global == n.global && b.multiline == n.multiline && b.ignoreCase == n.ignoreCase
        }
        if ("object" != typeof b || "object" != typeof n) {
            return !1
        }
        for (var k = m.length; k--;) {
            if (m[k] == b) {
                return !0
            }
        }
        m.push(b);
        var k = 0,
            j = !0;
        if ("[object Array]" == l) {
            if (k = b.length, j = k == n.length) {
                for (; k-- && (j = k in b == k in n && af(b[k], n[k], m));) {}
            }
        } else {
            if ("constructor" in b != "constructor" in n || b.constructor != n.constructor) {
                return !1
            }
            for (var i in b) {
                if (ar.has(b, i) && (k++, !(j = ar.has(n, i) && af(b[i], n[i], m)))) {
                    break
                }
            }
            if (j) {
                for (i in n) {
                    if (ar.has(n, i) && !k--) {
                        break
                    }
                }
                j = !k
            }
        }
        m.pop();
        return j
    }
    var ac = this,
        T = ac._,
        ak = {},
        ao = Array.prototype,
        aj = Object.prototype,
        aq = ao.slice,
        Q = ao.unshift,
        an = aj.toString,
        g = aj.hasOwnProperty,
        R = ao.forEach,
        h = ao.map,
        ai = ao.reduce,
        ah = ao.reduceRight,
        ae = ao.filter,
        ad = ao.every,
        ab = ao.some,
        ag = ao.indexOf,
        Z = ao.lastIndexOf,
        aj = Array.isArray,
        f = Object.keys,
        aa = Function.prototype.bind,
        ar = function(b) {
            return new am(b)
        };
    "undefined" !== typeof exports ? ("undefined" !== typeof module && module.exports && (exports = module.exports = ar), exports._ = ar) : ac._ = ar;
    ar.VERSION = "1.3.3";
    var ap = ar.each = ar.forEach = function(b, l, k) {
        if (b != null) {
            if (R && b.forEach === R) {
                b.forEach(l, k)
            } else {
                if (b.length === +b.length) {
                    for (var j = 0, i = b.length; j < i; j++) {
                        if (j in b && l.call(k, b[j], j, b) === ak) {
                            break
                        }
                    }
                } else {
                    for (j in b) {
                        if (ar.has(b, j) && l.call(k, b[j], j, b) === ak) {
                            break
                        }
                    }
                }
            }
        }
    };
    ar.map = ar.collect = function(j, l, i) {
        var k = [];
        if (j == null) {
            return k
        }
        if (h && j.map === h) {
            return j.map(l, i)
        }
        ap(j, function(b, n, m) {
            k[k.length] = l.call(i, b, n, m)
        });
        if (j.length === +j.length) {
            k.length = j.length
        }
        return k
    };
    ar.reduce = ar.foldl = ar.inject = function(b, l, k, j) {
        var i = arguments.length > 2;
        b == null && (b = []);
        if (ai && b.reduce === ai) {
            j && (l = ar.bind(l, j));
            return i ? b.reduce(l, k) : b.reduce(l)
        }
        ap(b, function(n, m, o) {
            if (i) {
                k = l.call(j, k, n, m, o)
            } else {
                k = n;
                i = true
            }
        });
        if (!i) {
            throw new TypeError("Reduce of empty array with no initial value")
        }
        return k
    };
    ar.reduceRight = ar.foldr = function(b, m, l, k) {
        var j = arguments.length > 2;
        b == null && (b = []);
        if (ah && b.reduceRight === ah) {
            k && (m = ar.bind(m, k));
            return j ? b.reduceRight(m, l) : b.reduceRight(m)
        }
        var i = ar.toArray(b).reverse();
        k && !j && (m = ar.bind(m, k));
        return j ? ar.reduce(i, m, l, k) : ar.reduce(i, m)
    };
    ar.find = ar.detect = function(j, l, i) {
        var k;
        X(j, function(b, n, m) {
            if (l.call(i, b, n, m)) {
                k = b;
                return true
            }
        });
        return k
    };
    ar.filter = ar.select = function(j, l, i) {
        var k = [];
        if (j == null) {
            return k
        }
        if (ae && j.filter === ae) {
            return j.filter(l, i)
        }
        ap(j, function(b, n, m) {
            l.call(i, b, n, m) && (k[k.length] = b)
        });
        return k
    };
    ar.reject = function(j, l, i) {
        var k = [];
        if (j == null) {
            return k
        }
        ap(j, function(b, n, m) {
            l.call(i, b, n, m) || (k[k.length] = b)
        });
        return k
    };
    ar.every = ar.all = function(j, l, i) {
        var k = true;
        if (j == null) {
            return k
        }
        if (ad && j.every === ad) {
            return j.every(l, i)
        }
        ap(j, function(b, n, m) {
            if (!(k = k && l.call(i, b, n, m))) {
                return ak
            }
        });
        return !!k
    };
    var X = ar.some = ar.any = function(b, k, j) {
        k || (k = ar.identity);
        var i = false;
        if (b == null) {
            return i
        }
        if (ab && b.some === ab) {
            return b.some(k, j)
        }
        ap(b, function(m, l, n) {
            if (i || (i = k.call(j, m, l, n))) {
                return ak
            }
        });
        return !!i
    };
    ar.include = ar.contains = function(j, k) {
        var i = false;
        if (j == null) {
            return i
        }
        if (ag && j.indexOf === ag) {
            return j.indexOf(k) != -1
        }
        return i = X(j, function(b) {
            return b === k
        })
    };
    ar.invoke = function(b, j) {
        var i = aq.call(arguments, 2);
        return ar.map(b, function(k) {
            return (ar.isFunction(j) ? j || k : k[j]).apply(k, i)
        })
    };
    ar.pluck = function(b, i) {
        return ar.map(b, function(j) {
            return j[i]
        })
    };
    ar.max = function(b, k, j) {
        if (!k && ar.isArray(b) && b[0] === +b[0]) {
            return Math.max.apply(Math, b)
        }
        if (!k && ar.isEmpty(b)) {
            return -Infinity
        }
        var i = {
            computed: -Infinity
        };
        ap(b, function(m, l, n) {
            l = k ? k.call(j, m, l, n) : m;
            l >= i.computed && (i = {
                value: m,
                computed: l
            })
        });
        return i.value
    };
    ar.min = function(b, k, j) {
        if (!k && ar.isArray(b) && b[0] === +b[0]) {
            return Math.min.apply(Math, b)
        }
        if (!k && ar.isEmpty(b)) {
            return Infinity
        }
        var i = {
            computed: Infinity
        };
        ap(b, function(m, l, n) {
            l = k ? k.call(j, m, l, n) : m;
            l < i.computed && (i = {
                value: m,
                computed: l
            })
        });
        return i.value
    };
    ar.shuffle = function(j) {
        var i = [],
            k;
        ap(j, function(b, l) {
            k = Math.floor(Math.random() * (l + 1));
            i[l] = i[k];
            i[k] = b
        });
        return i
    };
    ar.sortBy = function(b, k, j) {
        var i = ar.isFunction(k) ? k : function(l) {
            return l[k]
        };
        return ar.pluck(ar.map(b, function(m, l, n) {
            return {
                value: m,
                criteria: i.call(j, m, l, n)
            }
        }).sort(function(m, l) {
            var o = m.criteria,
                n = l.criteria;
            return o === void 0 ? 1 : n === void 0 ? -1 : o < n ? -1 : o > n ? 1 : 0
        }), "value")
    };
    ar.groupBy = function(b, k) {
        var j = {},
            i = ar.isFunction(k) ? k : function(l) {
                return l[k]
            };
        ap(b, function(m, l) {
            var n = i(m, l);
            (j[n] || (j[n] = [])).push(m)
        });
        return j
    };
    ar.sortedIndex = function(b, m, l) {
        l || (l = ar.identity);
        for (var k = 0, j = b.length; k < j;) {
            var i = k + j >> 1;
            l(b[i]) < l(m) ? k = i + 1 : j = i
        }
        return k
    };
    ar.toArray = function(b) {
        return !b ? [] : ar.isArray(b) || ar.isArguments(b) ? aq.call(b) : b.toArray && ar.isFunction(b.toArray) ? b.toArray() : ar.values(b)
    };
    ar.size = function(b) {
        return ar.isArray(b) ? b.length : ar.keys(b).length
    };
    ar.first = ar.head = ar.take = function(j, i, k) {
        return i != null && !k ? aq.call(j, 0, i) : j[0]
    };
    ar.initial = function(j, i, k) {
        return aq.call(j, 0, j.length - (i == null || k ? 1 : i))
    };
    ar.last = function(j, i, k) {
        return i != null && !k ? aq.call(j, Math.max(j.length - i, 0)) : j[j.length - 1]
    };
    ar.rest = ar.tail = function(j, i, k) {
        return aq.call(j, i == null || k ? 1 : i)
    };
    ar.compact = function(b) {
        return ar.filter(b, function(i) {
            return !!i
        })
    };
    ar.flatten = function(b, i) {
        return ar.reduce(b, function(j, k) {
            if (ar.isArray(k)) {
                return j.concat(i ? k : ar.flatten(k))
            }
            j[j.length] = k;
            return j
        }, [])
    };
    ar.without = function(b) {
        return ar.difference(b, aq.call(arguments, 1))
    };
    ar.uniq = ar.unique = function(b, k, j) {
        var j = j ? ar.map(b, j) : b,
            i = [];
        b.length < 3 && (k = true);
        ar.reduce(j, function(n, m, l) {
            if (k ? ar.last(n) !== m || !n.length : !ar.include(n, m)) {
                n.push(m);
                i.push(b[l])
            }
            return n
        }, []);
        return i
    };
    ar.union = function() {
        return ar.uniq(ar.flatten(arguments, true))
    };
    ar.intersection = ar.intersect = function(b) {
        var i = aq.call(arguments, 1);
        return ar.filter(ar.uniq(b), function(j) {
            return ar.every(i, function(k) {
                return ar.indexOf(k, j) >= 0
            })
        })
    };
    ar.difference = function(b) {
        var i = ar.flatten(aq.call(arguments, 1), true);
        return ar.filter(b, function(j) {
            return !ar.include(i, j)
        })
    };
    ar.zip = function() {
        for (var b = aq.call(arguments), k = ar.max(ar.pluck(b, "length")), j = Array(k), i = 0; i < k; i++) {
            j[i] = ar.pluck(b, "" + i)
        }
        return j
    };
    ar.indexOf = function(b, k, j) {
        if (b == null) {
            return -1
        }
        var i;
        if (j) {
            j = ar.sortedIndex(b, k);
            return b[j] === k ? j : -1
        }
        if (ag && b.indexOf === ag) {
            return b.indexOf(k)
        }
        j = 0;
        for (i = b.length; j < i; j++) {
            if (j in b && b[j] === k) {
                return j
            }
        }
        return -1
    };
    ar.lastIndexOf = function(j, i) {
        if (j == null) {
            return -1
        }
        if (Z && j.lastIndexOf === Z) {
            return j.lastIndexOf(i)
        }
        for (var k = j.length; k--;) {
            if (k in j && j[k] === i) {
                return k
            }
        }
        return -1
    };
    ar.range = function(j, i, n) {
        if (arguments.length <= 1) {
            i = j || 0;
            j = 0
        }
        for (var n = arguments[2] || 1, m = Math.max(Math.ceil((i - j) / n), 0), l = 0, k = Array(m); l < m;) {
            k[l++] = j;
            j = j + n
        }
        return k
    };
    var V = function() {};
    ar.bind = function(b, k) {
        var j, i;
        if (b.bind === aa && aa) {
            return aa.apply(b, aq.call(arguments, 1))
        }
        if (!ar.isFunction(b)) {
            throw new TypeError
        }
        i = aq.call(arguments, 2);
        return j = function() {
            if (!(this instanceof j)) {
                return b.apply(k, i.concat(aq.call(arguments)))
            }
            V.prototype = b.prototype;
            var l = new V,
                m = b.apply(l, i.concat(aq.call(arguments)));
            return Object(m) === m ? m : l
        }
    };
    ar.bindAll = function(b) {
        var i = aq.call(arguments, 1);
        i.length == 0 && (i = ar.functions(b));
        ap(i, function(j) {
            b[j] = ar.bind(b[j], b)
        });
        return b
    };
    ar.memoize = function(b, j) {
        var i = {};
        j || (j = ar.identity);
        return function() {
            var k = j.apply(this, arguments);
            return ar.has(i, k) ? i[k] : i[k] = b.apply(this, arguments)
        }
    };
    ar.delay = function(j, i) {
        var k = aq.call(arguments, 2);
        return setTimeout(function() {
            return j.apply(null, k)
        }, i)
    };
    ar.defer = function(b) {
        return ar.delay.apply(ar, [b, 1].concat(aq.call(arguments, 1)))
    };
    ar.throttle = function(r, q) {
        var p, o, n, m, l, k, b = ar.debounce(function() {
            l = m = false
        }, q);
        return function() {
            p = this;
            o = arguments;
            n || (n = setTimeout(function() {
                n = null;
                l && r.apply(p, o);
                b()
            }, q));
            m ? l = true : k = r.apply(p, o);
            b();
            m = true;
            return k
        }
    };
    ar.debounce = function(j, i, l) {
        var k;
        return function() {
            var m = this,
                b = arguments;
            l && !k && j.apply(m, b);
            clearTimeout(k);
            k = setTimeout(function() {
                k = null;
                l || j.apply(m, b)
            }, i)
        }
    };
    ar.once = function(j) {
        var i = false,
            k;
        return function() {
            if (i) {
                return k
            }
            i = true;
            return k = j.apply(this, arguments)
        }
    };
    ar.wrap = function(j, i) {
        return function() {
            var b = [j].concat(aq.call(arguments, 0));
            return i.apply(this, b)
        }
    };
    ar.compose = function() {
        var b = arguments;
        return function() {
            for (var i = arguments, j = b.length - 1; j >= 0; j--) {
                i = [b[j].apply(this, i)]
            }
            return i[0]
        }
    };
    ar.after = function(j, i) {
        return j <= 0 ? i() : function() {
            if (--j < 1) {
                return i.apply(this, arguments)
            }
        }
    };
    ar.keys = f || function(b) {
        if (b !== Object(b)) {
            throw new TypeError("Invalid object")
        }
        var j = [],
            i;
        for (i in b) {
            ar.has(b, i) && (j[j.length] = i)
        }
        return j
    };
    ar.values = function(b) {
        return ar.map(b, ar.identity)
    };
    ar.functions = ar.methods = function(b) {
        var j = [],
            i;
        for (i in b) {
            ar.isFunction(b[i]) && j.push(i)
        }
        return j.sort()
    };
    ar.extend = function(b) {
        ap(aq.call(arguments, 1), function(i) {
            for (var j in i) {
                b[j] = i[j]
            }
        });
        return b
    };
    ar.pick = function(b) {
        var i = {};
        ap(ar.flatten(aq.call(arguments, 1)), function(j) {
            j in b && (i[j] = b[j])
        });
        return i
    };
    ar.defaults = function(b) {
        ap(aq.call(arguments, 1), function(i) {
            for (var j in i) {
                b[j] == null && (b[j] = i[j])
            }
        });
        return b
    };
    ar.clone = function(b) {
        return !ar.isObject(b) ? b : ar.isArray(b) ? b.slice() : ar.extend({}, b)
    };
    ar.tap = function(j, i) {
        i(j);
        return j
    };
    ar.isEqual = function(j, i) {
        return af(j, i, [])
    };
    ar.isEmpty = function(b) {
        if (b == null) {
            return true
        }
        if (ar.isArray(b) || ar.isString(b)) {
            return b.length === 0
        }
        for (var i in b) {
            if (ar.has(b, i)) {
                return false
            }
        }
        return true
    };
    ar.isElement = function(b) {
        return !!(b && b.nodeType == 1)
    };
    ar.isArray = aj || function(b) {
        return an.call(b) == "[object Array]"
    };
    ar.isObject = function(b) {
        return b === Object(b)
    };
    ar.isArguments = function(b) {
        return an.call(b) == "[object Arguments]"
    };
    ar.isArguments(arguments) || (ar.isArguments = function(b) {
        return !(!b || !ar.has(b, "callee"))
    });
    ar.isFunction = function(b) {
        return an.call(b) == "[object Function]"
    };
    ar.isString = function(b) {
        return an.call(b) == "[object String]"
    };
    ar.isNumber = function(b) {
        return an.call(b) == "[object Number]"
    };
    ar.isFinite = function(b) {
        return ar.isNumber(b) && isFinite(b)
    };
    ar.isNaN = function(b) {
        return b !== b
    };
    ar.isBoolean = function(b) {
        return b === true || b === false || an.call(b) == "[object Boolean]"
    };
    ar.isDate = function(b) {
        return an.call(b) == "[object Date]"
    };
    ar.isRegExp = function(b) {
        return an.call(b) == "[object RegExp]"
    };
    ar.isNull = function(b) {
        return b === null
    };
    ar.isUndefined = function(b) {
        return b === void 0
    };
    ar.has = function(j, i) {
        return g.call(j, i)
    };
    ar.noConflict = function() {
        ac._ = T;
        return this
    };
    ar.identity = function(b) {
        return b
    };
    ar.times = function(j, i, l) {
        for (var k = 0; k < j; k++) {
            i.call(l, k)
        }
    };
    ar.escape = function(b) {
        return ("" + b).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#x27;").replace(/\//g, "&#x2F;")
    };
    ar.result = function(b, j) {
        if (b == null) {
            return null
        }
        var i = b[j];
        return ar.isFunction(i) ? i.call(b) : i
    };
    ar.mixin = function(b) {
        ap(ar.functions(b), function(i) {
            e(i, ar[i] = b[i])
        })
    };
    var d = 0;
    ar.uniqueId = function(j) {
        var i = d++;
        return j ? j + i : i
    };
    ar.templateSettings = {
        evaluate: /<%([\s\S]+?)%>/g,
        interpolate: /<%=([\s\S]+?)%>/g,
        escape: /<%-([\s\S]+?)%>/g
    };
    var Y = /.^/,
        al = {
            "\\": "\\",
            "'": "'",
            r: "\r",
            n: "\n",
            t: "\t",
            u2028: "\u2028",
            u2029: "\u2029"
        },
        W;
    for (W in al) {
        al[al[W]] = W
    }
    var c = /\\|'|\r|\n|\t|\u2028|\u2029/g,
        a = /\\(\\|'|r|n|t|u2028|u2029)/g,
        U = function(b) {
            return b.replace(a, function(j, i) {
                return al[i]
            })
        };
    ar.template = function(b, k, j) {
        j = ar.defaults(j || {}, ar.templateSettings);
        b = "__p+='" + b.replace(c, function(l) {
            return "\\" + al[l]
        }).replace(j.escape || Y, function(m, l) {
            return "'+\n_.escape(" + U(l) + ")+\n'"
        }).replace(j.interpolate || Y, function(m, l) {
            return "'+\n(" + U(l) + ")+\n'"
        }).replace(j.evaluate || Y, function(m, l) {
            return "';\n" + U(l) + "\n;__p+='"
        }) + "';\n";
        j.variable || (b = "with(obj||{}){\n" + b + "}\n");
        var b = "var __p='';var print=function(){__p+=Array.prototype.join.call(arguments, '')};\n" + b + "return __p;\n",
            i = new Function(j.variable || "obj", "_", b);
        if (k) {
            return i(k, ar)
        }
        k = function(l) {
            return i.call(this, l, ar)
        };
        k.source = "function(" + (j.variable || "obj") + "){\n" + b + "}";
        return k
    };
    ar.chain = function(b) {
        return ar(b).chain()
    };
    var am = function(b) {
        this._wrapped = b
    };
    ar.prototype = am.prototype;
    var S = function(b, i) {
            return i ? ar(b).chain() : b
        },
        e = function(b, i) {
            am.prototype[b] = function() {
                var j = aq.call(arguments);
                Q.call(j, this._wrapped);
                return S(i.apply(ar, j), this._chain)
            }
        };
    ar.mixin(ar);
    ap("pop,push,reverse,shift,sort,splice,unshift".split(","), function(j) {
        var i = ao[j];
        am.prototype[j] = function() {
            var k = this._wrapped;
            i.apply(k, arguments);
            var b = k.length;
            (j == "shift" || j == "splice") && b === 0 && delete k[0];
            return S(k, this._chain)
        }
    });
    ap(["concat", "join", "slice"], function(j) {
        var i = ao[j];
        am.prototype[j] = function() {
            return S(i.apply(this._wrapped, arguments), this._chain)
        }
    });
    am.prototype.chain = function() {
        this._chain = true;
        return this
    };
    am.prototype.value = function() {
        return this._wrapped
    }
}).call(this);
/*
 * jQuery Fixed Div plugin v1.0.0 <https://github.com/rwbaker/jQuery.fixed/>
 * @requires jQuery v1.2.6 or later
 * is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 *     very HEAVILY MODIFIED by Jon Huang
 */
(function(c) {
    var b = {
        top: 0,
        enabled: true,
        localOffset: 0,
        stopAtBottom: false,
        updateBottom: true,
        bottomPos: 0,
        offsetBottom: 0,
        isFixed: false,
        fixedSupport: true,
        forceAbsolutePositioning: false,
        onFixing: function() {},
        onUnfixing: function() {}
    };
    var a = {
        init: function(d) {
            return this.each(function() {
                var e = this;
                if (d) {
                    c.extend(b, d)
                }
                var g = c(this);
                var i = g.offset();
                offsetTop = (parseInt(i.top, 10) - parseInt(b.top, 10) - parseInt(g.css("padding-top"), 10));
                b.bottomPos = g.offsetParent().outerHeight() - g.outerHeight();
                b.offsetBottom = b.bottomPos + offsetTop;
                b.localOffset = g.position().top;
                if (/(iPhone|iPod|iPad)/i.test(navigator.userAgent)) {
                    if (/OS [2-4]_\d(_\d)? like Mac OS X/i.test(navigator.userAgent)) {
                        b.fixedSupport = false
                    } else {
                        if (/CPU like Mac OS X/i.test(navigator.userAgent)) {
                            b.fixedSupport = false
                        } else {
                            b.fixedSupport = true
                        }
                    }
                } else {
                    b.fixedSupport = true
                }
                if (b.forceAbsolutePositioning) {
                    b.fixedSupport = false
                }
                g.css("position", "absolute");
                if (c(window).scrollTop() > offsetTop) {
                    f(b.top)
                }
                c(window).on("scroll.fixie", _.debounce(function() {
                    if (!b.enabled) {
                        return
                    }
                    var j = c(window).scrollTop();
                    if (b.stopAtBottom && b.updateBottom) {
                        b.bottomPos = g.offsetParent().outerHeight() - g.outerHeight();
                        b.offsetBottom = b.bottomPos + offsetTop
                    }
                    if (j < offsetTop) {
                        h(b.localOffset);
                        a._setFix(false, g)
                    } else {
                        if (b.stopAtBottom && (j > b.offsetBottom)) {
                            h(b.bottomPos);
                            a._setFix(true, g)
                        } else {
                            if (b.fixedSupport) {
                                f(b.top)
                            } else {
                                h(j + b.top - offsetTop)
                            }
                            a._setFix(true, g)
                        }
                    }
                }, 0));

                function f(j) {
                    g.css("position", "fixed").css({
                        top: j + "px"
                    })
                }

                function h(j) {
                    g.css("position", "absolute").css({
                        top: j + "px"
                    })
                }
            })
        },
        enable: function() {
            return this.each(function() {
                b.enabled = true
            })
        },
        disable: function() {
            return this.each(function() {
                b.enabled = false;
                c(this).css({
                    position: "absolute",
                    top: b.localOffset + "px"
                })
            })
        },
        update: function() {
            return this.each(function() {
                var d = c(this);
                var e = d.offset();
                e = (parseInt(e.top, 10) - parseInt(b.top, 10));
                b.bottomPos = Math.max(parseInt(d.offsetParent().css("height"), 10), d.offsetParent().height()) - c(window).height();
                b.offsetBottom = b.bottomPos + e
            })
        },
        _setFix: function(d, e) {
            if (d) {
                if (!b.isFixed && b.onFixing) {
                    b.onFixing()
                }
                b.isFixed = true;
                e.addClass("nytmm_fixed")
            } else {
                if (b.isFixed && b.onUnfixing) {
                    b.onUnfixing()
                }
                b.isFixed = false;
                e.removeClass("nytmm_fixed")
            }
        }
    };
    c.fn.fixie = function(d) {
        if (a[d]) {
            return a[d].apply(this, Array.prototype.slice.call(arguments, 1))
        } else {
            if (typeof d === "object" || !d) {
                return a.init.apply(this, arguments)
            } else {
                c.error("Method " + d + " does not exist on jQuery.fixie")
            }
        }
    }
})(jQuery || NYTD.jQuery);
NYTD = NYTD || {};
NYTD.shareTools = (function(e) {
    var q = {
        mainClassName: "shareTools",
        itemClassName: "shareToolsItem",
        defaultActiveShares: ["facebook|Facebook", "google|Google+", "twitter|Twitter"],
        defaultUrl: window.location.href.replace(/#.*/, ""),
        defaultTitle: e('meta[property="og:title"]').attr("content") || document.title,
        defaultDescription: e("meta[name=description]").attr("content") || "",
        defaultAdPosition: "Frame4A",
        defaultOverlayAdPosition: "Frame6A",
        defaultWidth: 600,
        defaultHeight: 450,
        labelSpecialChar: "|",
        emailThisFormInitiated: false,
        loadedAdPositions: [],
        shortUrlApi: "http://www.nytimes.com/svc/bitly/shorten.jsonp",
        count: 0
    };
    var b = {
        overlay: '		<div id="shareToolsOverlayContainer" class="shareToolsOverlayContainer shareToolsInstance shareToolsThemeClassic" style="display:none;">			<div id="shareToolsOverlay" class="shareToolsOverlay"></div>			<div id="shareToolsDialogBox" class="shareToolsDialogBox">				<div class="shareToolsInset">					<div class="shareToolsHeader shareToolsOpposingFloatControl shareToolsWrap"><a href="#" class="element2 shareToolsDialogBoxClose" id="shareToolsDialogBoxClose">Close</a><h5 class="element1">Share</h5></div>					<div id="shareToolsDialogBoxContent" class="shareToolsDialogBoxContent shareToolsSingleRule">						<div class="shareToolsBox shareToolsWrap"><div class="shareToolsColumn"><div class="shareToolsInset"><ul class="shareToolsList">						<% jQuery.each(shares, function(index, share) { %>						<li data-share="<%= share.name %>" class="<%= share.classes %>"><span><%= share.label %></span></li>						<% }); %></ul></div></div><div class="shareToolsColumn shareToolsLastColumn"><div class="shareToolsInset"><ul class="shareToolsList"></ul></div></div></div>					</div>					<div id="shareToolsFooter" class="shareToolsFooter"><div id="<%= options.adPosition %>" class="<%= options.adPosition %>"></div></div>				</div>			</div>		</div>		',
        shareList: '<div class="shareToolsBox"><ul class="shareToolsList">		<% jQuery.each(shares, function(index, share) { if (share.name == "ad") { %>			<li data-share="<%= share.name %>" class="<%= share.classes %> <%= share.adPosition %>" id="<%= share.adPosition %>"></li>		<% } else if (share.type == "link") { %>			<li data-share="<%= share.name %>" class="<%= share.classes %>"><a href="<%= share.postUrl %>"><%= share.label %></a></li>		<% } else { %>			<li data-share="<%= share.name %>" class="<%= share.classes %>"><span><%= share.label %></span></li>		<% }		}); %></ul></div>		',
        emailThisForm: '<form action="<%= data.postUrl %>" enctype="application/x-www-form-urlencoded" id="shareToolsEmailThis" name="shareToolsEmailThis" method="POST"><input type="hidden" value="1" name="type"><input type="hidden" value="<%= data.url %>" name="url"><input type="hidden" value="<%= data.title %>" name="title"><input type="hidden" value="" name="description"><input type="hidden" value="" name="asset_id"><input type="hidden" value="" name="pub_date"><input type="hidden" value="" name="author"><input type="hidden" value="" name="col_name"><input type="hidden" value="" name="source"><input type="hidden" value="" name="section"><input type="hidden" value="" name="nytdsection"><input type="hidden" value="" name="nytdsubsection"><input type="hidden" value="" name="adx_setup_tag"><input type="hidden" value="" name="adx_keywords"><input type="hidden" value="<%= data.hash %>" name="encrypted_key"></form>'
    };
    var n = {
        facebook2: {
            active: true,
            onShowAll: true,
            label: "Facebook",
            postUrl: "http://www.facebook.com/sharer.php",
            postType: "popup",
            shareParameters: {
                url: "p[url]",
                title: "p[title]",
                thumbnail: "p[images][0]",
                description: "p[summary]"
            },
            urlParameters: {
                s: "100"
            },
            smid: "fb-share",
            width: 655,
            height: 430
        },
        facebook: {
            active: true,
            onShowAll: true,
            label: "Facebook",
            postUrl: "http://www.facebook.com/sharer.php",
            postType: "popup",
            shareParameters: {
                url: "u"
            },
            smid: "fb-share",
            width: 655,
            height: 430
        },
        twitter: {
            active: true,
            onShowAll: true,
            label: "Twitter",
            postUrl: "https://twitter.com/share",
            postType: "popup",
            shareParameters: {
                url: "url",
                title: "text"
            },
            smid: "tw-share",
            width: 600,
            height: 450
        },
        google: {
            active: true,
            onShowAll: true,
            label: "Google+",
            postUrl: "https://plus.google.com/share",
            postType: "popup",
            shareParameters: {
                url: "url"
            },
            urlParameters: {
                hl: "en-US"
            },
            smid: "go-share",
            width: 600,
            height: 600
        },
        tumblr: {
            active: true,
            onShowAll: true,
            label: "Tumblr",
            postUrl: "http://www.tumblr.com/share/link",
            postType: "popup",
            shareParameters: {
                url: "url",
                title: "name",
                description: "description"
            },
            smid: "tu-share",
            width: 560
        },
        linkedin: {
            active: true,
            onShowAll: true,
            label: "Linkedin",
            postUrl: "http://www.linkedin.com/shareArticle",
            postType: "popup",
            shareParameters: {
                url: "url",
                title: "title",
                description: "summary"
            },
            urlParameters: {
                mini: "true",
                source: "The New York Times"
            },
            smid: "li-share",
            width: 750,
            height: 450
        },
        reddit: {
            active: true,
            onShowAll: true,
            label: "Reddit",
            postUrl: "http://www.reddit.com/submit",
            postType: "popup",
            shareParameters: {
                url: "url",
                title: "title"
            },
            smid: "re-share",
            width: 854,
            height: 550
        },
        email: {
            active: true,
            onShowAll: true,
            label: "Email",
            formAction: "http://www.nytimes.com/mem/emailthis.html",
            postType: "popup"
        },
        permalink: {
            active: true,
            onShowAll: true,
            label: "Permalink",
            postUrl: "http://www.nytimes.com/export_html/common/new_article_post.html",
            postType: "popup",
            shareParameters: {
                url: "url",
                title: "title",
                description: "summary"
            },
            smid: "pl-share",
            width: 460,
            height: 380
        },
        showall: {
            active: true,
            onShowAll: false,
            label: "Show All"
        },
        reprints: {
            active: true,
            onShowAll: false,
            label: "Reprints",
            postUrl: "https://s100.copyright.com/AppDispatchServlet",
            postType: "popup",
            shareParameters: {
                url: "contentID"
            },
            urlParameters: {
                publisherName: "The New York Times",
                publication: "nytimes.com",
                token: "",
                orderBeanReset: "true",
                postType: "",
                wordCount: "12",
                title: e(".articleHeadline").text() != "" ? e(".articleHeadline").text() : document.title,
                publicationDate: e("meta[name=dat]").attr("content") || "",
                author: e("meta[name=byl]").attr("content") || ""
            }
        },
        print: {
            active: true,
            onShowAll: false,
            label: "Print",
            postUrl: q.defaultUrl,
            postType: "link",
            urlParameters: {
                pagewanted: "print"
            }
        },
        singlepage: {
            active: true,
            onShowAll: false,
            label: "Single Page",
            postUrl: q.defaultUrl,
            postType: "link",
            urlParameters: {
                pagewanted: "all"
            }
        },
        ad: {
            active: true,
            onShowAll: false,
            label: "Advertisement"
        }
    };

    function l(t, J) {
        t = e(t);
        if (!t.hasClass("shareToolsInstance")) {
            var J = J || t.data(),
                x = J.url || q.defaultUrl,
                K = J.title || q.defaultTitle,
                L = J.thumbnail || q.defaultThumbnail,
                C = J.description || q.defaultDescription,
                D = J.shares ? J.shares.split(",") : q.defaultActiveShares,
                z = J.adPosition ? J.adPosition : q.defaultAdPosition,
                G = e("#pageLinks").length > 0 ? true : false,
                w = false,
                y = [],
                F, s, A, v, u, I;
            q.count += 1;
            t.addClass("shareToolsInstance").data({
                url: x,
                title: K,
                description: C,
                thumbnail: L,
                count: q.count
            });
            for (var E = 0, B = D.length; E < B; E++) {
                F = D[E].split(q.labelSpecialChar);
                s = F[0];
                if (typeof n[s] !== "undefined") {
                    if (s != "singlepage" || (s == "singlepage" && G)) {
                        if (n[s].active) {
                            if (s == "ad") {
                                w = true
                            }
                            v = n[s].postType || "popup";
                            u = v == "link" ? f(s) : "";
                            I = q.itemClassName + " " + q.itemClassName + h(s);
                            if (D[E].indexOf(q.labelSpecialChar) !== -1) {
                                if (F[1]) {
                                    A = F[1]
                                } else {
                                    A = "";
                                    I += " noLabel"
                                }
                            } else {
                                A = n[s].label
                            }
                            y.push({
                                label: A,
                                name: s,
                                classes: I,
                                adPosition: w ? z : "",
                                type: v,
                                postUrl: u
                            })
                        }
                    }
                }
            }
            t.html(NYTD.Template(b.shareList, {
                shares: y
            }));
            var H = t.find("li");
            H.filter(":first").addClass("firstItem");
            H.filter(":last").addClass("lastItem");
            if (w) {
                g(z)
            }
        }
    }

    function r() {
        var u = [],
            w, t;
        e.each(n, function(x, y) {
            if (n[x].active && n[x].onShowAll) {
                w = y.label;
                t = q.itemClassName + " " + q.itemClassName + h(x);
                u.push({
                    label: w,
                    name: x,
                    classes: t
                })
            }
        });
        e("body").append(NYTD.Template(b.overlay, {
            shares: u,
            options: {
                adPosition: q.defaultOverlayAdPosition
            }
        }));
        var v = e("#shareToolsDialogBoxContent").find(".shareToolsItem");
        var s = Math.ceil(v.length / 2);
        e(v).filter(":gt(" + (s - 1) + ")").detach().appendTo(e("#shareToolsDialogBoxContent .shareToolsLastColumn ul"));
        e("#shareToolsDialogBoxClose").click(function(x) {
            x.preventDefault();
            e("#shareToolsOverlayContainer").fadeOut()
        })
    }

    function g(s) {
        if (window.adxads) {
            window.adxads = null
        }
        e.getScript("http://www.nytimes.com/adx/bin/adx_remote.html?type=fastscript&page=www.nytimes.com/yr/mo/day&posall=" + s + "&query=qstring&keywords=", function(t, v, u) {
            if (window.adxads) {
                e("#" + s).html(window.adxads[0]);
                q.loadedAdPositions.push(s)
            }
        })
    }

    function o() {
        widgets = e("." + q.mainClassName);
        if (widgets.length > 0) {
            widgets.each(function(s, t) {
                l(e(this))
            })
        }
    }

    function d(s, u) {
        var t = e("meta[name=emailThisHash]").attr("content") || "";
        templateData = {
            postUrl: n.email.formAction,
            url: s,
            title: u,
            hash: t
        };
        e("body").append(NYTD.Template(b.emailThisForm, {
            data: templateData
        }));
        q.emailThisFormInitiated = true
    }

    function p() {
        var s = "." + q.itemClassName + " span";
        e("body").delegate(s, "click", function(w) {
            var t = e(this).parent().data("share"),
                v = e(this).closest(".shareToolsInstance").data(),
                u = n[t];
            var x = e.extend(true, {}, v);
            if (u.smid) {
                x.url = x.url + c(x.url) + "smid=" + u.smid
            }
            if (t == "showall") {
                if (e.inArray(q.defaultOverlayAdPosition, q.loadedAdPositions) === -1) {
                    g(q.defaultOverlayAdPosition)
                }
                e("#shareToolsOverlayContainer").data("url", x.url).data("title", x.title).data("description", x.description).fadeIn()
            } else {
                if (t == "email") {
                    if (a()) {
                        if (q.emailThisFormInitiated === false) {
                            d(x.url, x.title)
                        }
                        e("#shareToolsEmailThis").submit()
                    } else {
                        window.location.href = "https://myaccount.nytimes.com/auth/login?URI=" + i()
                    }
                } else {
                    if (t == "twitter") {
                        k(t, x)
                    } else {
                        m(t, x)
                    }
                }
            }
            j("DCS.dcssip", "www.nytimes.com", "DCS.dcsuri", "/Article-Tool-Share-" + h(t) + ".html", "WT.ti", "Article-Tool-Share-" + h(t), "WT.z_dcsm", "1", "WT.z_loc", x.count)
        });
        e("html").delegate("#shareToolsOverlayDialogBox", "click", function(t) {
            t.stopPropagation()
        });
        e("html").delegate("#shareToolsOverlay", "click", function(t) {
            t.preventDefault();
            e("#shareToolsOverlayContainer").fadeOut()
        })
    }

    function m(w, x) {
        var u = n[w],
            v = u.width ? u.width : q.defaultWidth,
            s = u.height ? u.height : q.defaultHeight,
            t = f(w, x);
        window.open(t, w + "Share", "toolbar=0,status=0,height=" + s + ",width=" + v + ",scrollbars=yes,resizable=yes")
    }

    function f(u, v) {
        var s = n[u],
            t = [],
            x = s.postUrl;
        if (s.shareParameters && v) {
            var w;
            e.each(s.shareParameters, function(z, y) {
                w = v[z];
                t.push(y + "=" + encodeURIComponent(w))
            })
        }
        if (s.urlParameters) {
            e.each(s.urlParameters, function(y, z) {
                t.push(y + "=" + encodeURIComponent(z))
            })
        }
        t = t.join("&");
        x = x + c(x) + t;
        return x
    }

    function h(s) {
        return s.charAt(0).toUpperCase() + s.slice(1)
    }

    function c(s) {
        return s.indexOf("?") !== -1 ? "&" : "?"
    }

    function a() {
        var s = window.regstatus && window.regstatus == "registered" ? true : false;
        return s
    }

    function i() {
        var t = window.location.href.replace(/[\?&]+gwh=[^&]+/, ""),
            v = t.split("?"),
            u = v[0],
            s = v[1];
        if (s) {
            s = encodeURIComponent(s).replace("%", "Q");
            t = u + "&OQ=" + s
        } else {
            t = u
        }
        return t
    }

    function k(t, v) {
        var u = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">		<html><head>		<script type="text/javascript" src="http://graphics8.nytimes.com/js/common.js"><\/script>		<script type="text/javascript">		function loadShortUrl() {			var url;			NYTD.jQuery.ajax({				url: "' + q.shortUrlApi + '",				dataType: "jsonp",				data: { "url" : "' + v.url + '" }			}).success(function(data, textStatus, jqXHR){				if (data && data.payload && data.payload.short_url) {					short_url = data.payload.short_url;					url = short_url;				}				shortUrlRedirect(url);			}).error(function(jqXHR, textStatus, errorThrown){				shortUrlRedirect(url);			});		};		function shortUrlRedirect(url) {			window.location.href = "' + n[t].postUrl + '?url=" + encodeURIComponent(url) + "&text=' + encodeURIComponent(v.title) + '";		};		<\/script>		</head>		<body onload="loadShortUrl();"></body></html>';
        var s = window.open("", t + "Share", "toolbar=0,status=0,height=" + n[t].height + ",width=" + n[t].width + ",scrollbars=yes,resizable=yes");
        s.document.write(u);
        s.document.close()
    }

    function j() {
        if ("dcsMultiTrack" in window) {
            dcsMultiTrack.apply(this, arguments)
        } else {
            setTimeout(function() {
                j.apply(this, arguments)
            }, 1000)
        }
    }
    return {
        init: l,
        initOverlay: r,
        initShareElements: o,
        setupHandlers: p
    }
})(jQuery);
NYTD.Template = function(c, b) {
    var a = !/\W/.test(c) ? cache[c] = cache[c] || NYTD.Template(document.getElementById(c).innerHTML) : new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('" + c.replace(/[\r\t\n]/g, " ").split("<%").join("\t").replace(/((^|%>)[^\t]*)'/g, "$1\r").replace(/\t=(.*?)%>/g, "',$1,'").split("\t").join("');").split("%>").join("p.push('").split("\r").join("\\'") + "');}return p.join('');");
    return b ? a(b) : a
};
jQuery(document).ready(function() {
    NYTD.shareTools.initOverlay();
    NYTD.shareTools.initShareElements();
    NYTD.shareTools.setupHandlers()
});
(function(c) {
    var a = c.scrollTo = function(f, e, d) {
        c(window).scrollTo(f, e, d)
    };
    a.defaults = {
        axis: "xy",
        duration: parseFloat(c.fn.jquery) >= 1.3 ? 0 : 1
    };
    a.window = function(d) {
        return c(window)._scrollable()
    };
    c.fn._scrollable = function() {
        return this.map(function() {
            var e = this,
                d = !e.nodeName || c.inArray(e.nodeName.toLowerCase(), ["iframe", "#document", "html", "body"]) != -1;
            if (!d) {
                return e
            }
            var f = (e.contentWindow || e).document || e.ownerDocument || e;
            return c.browser.safari || f.compatMode == "BackCompat" ? f.body : f.documentElement
        })
    };
    c.fn.scrollTo = function(f, e, d) {
        if (typeof e == "object") {
            d = e;
            e = 0
        }
        if (typeof d == "function") {
            d = {
                onAfter: d
            }
        }
        if (f == "max") {
            f = 9000000000
        }
        d = c.extend({}, a.defaults, d);
        e = e || d.speed || d.duration;
        d.queue = d.queue && d.axis.length > 1;
        if (d.queue) {
            e /= 2
        }
        d.offset = b(d.offset);
        d.over = b(d.over);
        return this._scrollable().each(function() {
            var l = this,
                j = c(l),
                k = f,
                i, g = {},
                m = j.is("html,body");
            switch (typeof k) {
                case "number":
                case "string":
                    if (/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(k)) {
                        k = b(k);
                        break
                    }
                    k = c(k, this);
                case "object":
                    if (k.is || k.style) {
                        i = (k = c(k)).offset()
                    }
            }
            c.each(d.axis.split(""), function(q, r) {
                var s = r == "x" ? "Left" : "Top",
                    u = s.toLowerCase(),
                    p = "scroll" + s,
                    o = l[p],
                    n = a.max(l, r);
                if (i) {
                    g[p] = i[u] + (m ? 0 : o - j.offset()[u]);
                    if (d.margin) {
                        g[p] -= parseInt(k.css("margin" + s)) || 0;
                        g[p] -= parseInt(k.css("border" + s + "Width")) || 0
                    }
                    g[p] += d.offset[u] || 0;
                    if (d.over[u]) {
                        g[p] += k[r == "x" ? "width" : "height"]() * d.over[u]
                    }
                } else {
                    var t = k[u];
                    g[p] = t.slice && t.slice(-1) == "%" ? parseFloat(t) / 100 * n : t
                }
                if (/^\d+$/.test(g[p])) {
                    g[p] = g[p] <= 0 ? 0 : Math.min(g[p], n)
                }
                if (!q && d.queue) {
                    if (o != g[p]) {
                        h(d.onAfterFirst)
                    }
                    delete g[p]
                }
            });
            h(d.onAfter);

            function h(n) {
                j.animate(g, e, d.easing, n && function() {
                    n.call(this, f, d)
                })
            }
        }).end()
    };
    a.max = function(j, i) {
        var h = i == "x" ? "Width" : "Height",
            e = "scroll" + h;
        if (!c(j).is("html,body")) {
            return j[e] - c(j)[h.toLowerCase()]()
        }
        var g = "client" + h,
            f = j.ownerDocument.documentElement,
            d = j.ownerDocument.body;
        return Math.max(f[e], d[e]) - Math.min(f[g], d[g])
    };

    function b(d) {
        return typeof d == "object" ? d : {
            top: d,
            left: d
        }
    }
})(jQuery);
(function(v) {
    var u = "0.3.4",
        t = "hasOwnProperty",
        s = /[\.\/]/,
        r = "*",
        q = function() {},
        p = function(d, c) {
            return d - c
        },
        o, n, m = {
            n: {}
        },
        l = function(D, C) {
            var B = m,
                A = n,
                z = Array.prototype.slice.call(arguments, 2),
                y = l.listeners(D),
                x = 0,
                w = !1,
                k, j = [],
                i = {},
                h = [],
                g = o,
                G = [];
            o = D, n = 0;
            for (var F = 0, E = y.length; F < E; F++) {
                "zIndex" in y[F] && (j.push(y[F].zIndex), y[F].zIndex < 0 && (i[y[F].zIndex] = y[F]))
            }
            j.sort(p);
            while (j[x] < 0) {
                k = i[j[x++]], h.push(k.apply(C, z));
                if (n) {
                    n = A;
                    return h
                }
            }
            for (F = 0; F < E; F++) {
                k = y[F];
                if ("zIndex" in k) {
                    if (k.zIndex == j[x]) {
                        h.push(k.apply(C, z));
                        if (n) {
                            break
                        }
                        do {
                            x++, k = i[j[x]], k && h.push(k.apply(C, z));
                            if (n) {
                                break
                            }
                        } while (k)
                    } else {
                        i[k.zIndex] = k
                    }
                } else {
                    h.push(k.apply(C, z));
                    if (n) {
                        break
                    }
                }
            }
            n = A, o = g;
            return h.length ? h : null
        };
    l.listeners = function(F) {
        var E = F.split(s),
            D = m,
            C, B, A, z, y, x, w, j, e = [D],
            d = [];
        for (z = 0, y = E.length; z < y; z++) {
            j = [];
            for (x = 0, w = e.length; x < w; x++) {
                D = e[x].n, B = [D[E[z]], D[r]], A = 2;
                while (A--) {
                    C = B[A], C && (j.push(C), d = d.concat(C.f || []))
                }
            }
            e = j
        }
        return d
    }, l.on = function(f, d) {
        var w = f.split(s),
            k = m;
        for (var j = 0, i = w.length; j < i; j++) {
            k = k.n, !k[w[j]] && (k[w[j]] = {
                n: {}
            }), k = k[w[j]]
        }
        k.f = k.f || [];
        for (j = 0, i = k.f.length; j < i; j++) {
            if (k.f[j] == d) {
                return q
            }
        }
        k.f.push(d);
        return function(b) {
            +b == +b && (d.zIndex = +b)
        }
    }, l.stop = function() {
        n = 1
    }, l.nt = function(b) {
        if (b) {
            return (new RegExp("(?:\\.|\\/|^)" + b + "(?:\\.|\\/|$)")).test(o)
        }
        return o
    }, l.off = l.unbind = function(D, C) {
        var B = D.split(s),
            A, z, y, x, w, j, e, d = [m];
        for (x = 0, w = B.length; x < w; x++) {
            for (j = 0; j < d.length; j += y.length - 2) {
                y = [j, 1], A = d[j].n;
                if (B[x] != r) {
                    A[B[x]] && y.push(A[B[x]])
                } else {
                    for (z in A) {
                        A[t](z) && y.push(A[z])
                    }
                }
                d.splice.apply(d, y)
            }
        }
        for (x = 0, w = d.length; x < w; x++) {
            A = d[x];
            while (A.n) {
                if (C) {
                    if (A.f) {
                        for (j = 0, e = A.f.length; j < e; j++) {
                            if (A.f[j] == C) {
                                A.f.splice(j, 1);
                                break
                            }
                        }!A.f.length && delete A.f
                    }
                    for (z in A.n) {
                        if (A.n[t](z) && A.n[z].f) {
                            var c = A.n[z].f;
                            for (j = 0, e = c.length; j < e; j++) {
                                if (c[j] == C) {
                                    c.splice(j, 1);
                                    break
                                }
                            }!c.length && delete A.n[z].f
                        }
                    }
                } else {
                    delete A.f;
                    for (z in A.n) {
                        A.n[t](z) && A.n[z].f && delete A.n[z].f
                    }
                }
                A = A.n
            }
        }
    }, l.once = function(e, d) {
        var f = function() {
            var a = d.apply(this, arguments);
            l.unbind(e, f);
            return a
        };
        return l.on(e, f)
    }, l.version = u, l.toString = function() {
        return "You are running Eve " + u
    }, typeof module != "undefined" && module.exports ? module.exports = l : typeof define != "undefined" ? define("eve", [], function() {
        return l
    }) : v.eve = l
})(this),
function() {
    function cX(d) {
        for (var c = 0; c < ab.length; c++) {
            ab[c].el.paper == d && ab.splice(c--, 1)
        }
    }

    function c0(br, bq, bp, bo, bn, bm) {
        bp = c4(bp);
        var bl, bk, bj, bi = [],
            bh, bg, be, bb = br.ms,
            Z = {},
            X = {},
            V = {};
        if (bo) {
            for (Q = 0, C = ab.length; Q < C; Q++) {
                var T = ab[Q];
                if (T.el.id == bq.id && T.anim == br) {
                    T.percent != bp ? (ab.splice(Q, 1), bj = 1) : bk = T, bq.attr(T.totalOrigin);
                    break
                }
            }
        } else {
            bo = +X
        }
        for (var Q = 0, C = br.percents.length; Q < C; Q++) {
            if (br.percents[Q] == bp || br.percents[Q] > bo * br.top) {
                bp = br.percents[Q], bg = br.percents[Q - 1] || 0, bb = bb / br.top * (bp - bg), bh = br.percents[Q + 1], bl = br.anim[bp];
                break
            }
            bo && bq.attr(br.anim[br.percents[Q]])
        }
        if (!!bl) {
            if (!bk) {
                for (var bf in bl) {
                    if (bl[aV](bf)) {
                        if (cS[aV](bf) || bq.paper.customAttributes[aV](bf)) {
                            Z[bf] = bq.attr(bf), Z[bf] == null && (Z[bf] = cV[bf]), X[bf] = bl[bf];
                            switch (cS[bf]) {
                                case dv:
                                    V[bf] = (X[bf] - Z[bf]) / bb;
                                    break;
                                case "colour":
                                    Z[bf] = a8.getRGB(Z[bf]);
                                    var bd = a8.getRGB(X[bf]);
                                    V[bf] = {
                                        r: (bd.r - Z[bf].r) / bb,
                                        g: (bd.g - Z[bf].g) / bb,
                                        b: (bd.b - Z[bf].b) / bb
                                    };
                                    break;
                                case "path":
                                    var bc = dA(Z[bf], X[bf]),
                                        ba = bc[1];
                                    Z[bf] = bc[0], V[bf] = [];
                                    for (Q = 0, C = Z[bf].length; Q < C; Q++) {
                                        V[bf][Q] = [0];
                                        for (var Y = 1, W = Z[bf][Q].length; Y < W; Y++) {
                                            V[bf][Q][Y] = (ba[Q][Y] - Z[bf][Q][Y]) / bb
                                        }
                                    }
                                    break;
                                case "transform":
                                    var U = bq._,
                                        S = aM(U[bf], X[bf]);
                                    if (S) {
                                        Z[bf] = S.from, X[bf] = S.to, V[bf] = [], V[bf].real = !0;
                                        for (Q = 0, C = Z[bf].length; Q < C; Q++) {
                                            V[bf][Q] = [Z[bf][Q][0]];
                                            for (Y = 1, W = Z[bf][Q].length; Y < W; Y++) {
                                                V[bf][Q][Y] = (X[bf][Q][Y] - Z[bf][Q][Y]) / bb
                                            }
                                        }
                                    } else {
                                        var N = bq.matrix || new aL,
                                            s = {
                                                _: {
                                                    transform: U.transform
                                                },
                                                getBBox: function() {
                                                    return bq.getBBox(1)
                                                }
                                            };
                                        Z[bf] = [N.a, N.b, N.c, N.d, N.e, N.f], dT(s, X[bf]), X[bf] = s._.transform, V[bf] = [(s.matrix.a - N.a) / bb, (s.matrix.b - N.b) / bb, (s.matrix.c - N.c) / bb, (s.matrix.d - N.d) / bb, (s.matrix.e - N.e) / bb, (s.matrix.f - N.f) / bb]
                                    }
                                    break;
                                case "csv":
                                    var r = aF(bl[bf])[aD](a3),
                                        n = aF(Z[bf])[aD](a3);
                                    if (bf == "clip-rect") {
                                        Z[bf] = n, V[bf] = [], Q = n.length;
                                        while (Q--) {
                                            V[bf][Q] = (r[Q] - Z[bf][Q]) / bb
                                        }
                                    }
                                    X[bf] = r;
                                    break;
                                default:
                                    r = [][aN](bl[bf]), n = [][aN](Z[bf]), V[bf] = [], Q = bq.paper.customAttributes[bf].length;
                                    while (Q--) {
                                        V[bf][Q] = ((r[Q] || 0) - (n[Q] || 0)) / bb
                                    }
                            }
                        }
                    }
                }
                var g = bl.easing,
                    c = a8.easing_formulas[g];
                if (!c) {
                    c = aF(g).match(dc);
                    if (c && c.length == 5) {
                        var a = c;
                        c = function(b) {
                            return c6(b, +a[1], +a[2], +a[3], +a[4], bb)
                        }
                    } else {
                        c = cU
                    }
                }
                be = bl.start || br.start || +(new Date), T = {
                    anim: br,
                    percent: bp,
                    timestamp: be,
                    start: be + (br.del || 0),
                    status: 0,
                    initstatus: bo || 0,
                    stop: !1,
                    ms: bb,
                    easing: c,
                    from: Z,
                    diff: V,
                    to: X,
                    el: bq,
                    callback: bl.callback,
                    prev: bg,
                    next: bh,
                    repeat: bm || br.times,
                    origin: bq.attr(),
                    totalOrigin: bn
                }, ab.push(T);
                if (bo && !bk && !bj) {
                    T.stop = !0, T.start = new Date - bb * bo;
                    if (ab.length == 1) {
                        return db()
                    }
                }
                bj && (T.start = new Date - T.ms * bo), ab.length == 1 && aa(db)
            } else {
                bk.initstatus = bo, bk.start = new Date - bk.ms * bo
            }
            eve("raphael.anim.start." + bq.id, bq, br)
        }
    }

    function c3(g, f) {
        var j = [],
            i = {};
        this.ms = f, this.times = 1;
        if (g) {
            for (var h in g) {
                g[aV](h) && (i[c4(h)] = g[h], j.push(c4(h)))
            }
            j.sort(cZ)
        }
        this.anim = i, this.top = j[j.length - 1], this.percents = j
    }

    function c6(D, C, B, A, z, y) {
        function p(h, g) {
            var E, o, n, m, l, i;
            for (n = h, i = 0; i < 8; i++) {
                m = r(n) - h;
                if (ao(m) < g) {
                    return n
                }
                l = (3 * v * n + 2 * w) * n + x;
                if (ao(l) < 0.000001) {
                    break
                }
                n = n - m / l
            }
            E = 0, o = 1, n = h;
            if (n < E) {
                return E
            }
            if (n > o) {
                return o
            }
            while (E < o) {
                m = r(n);
                if (ao(m - h) < g) {
                    return n
                }
                h > m ? E = n : o = n, n = (o - E) / 2 + E
            }
            return n
        }

        function q(e, d) {
            var f = p(e, d);
            return ((s * f + t) * f + u) * f
        }

        function r(b) {
            return ((v * b + w) * b + x) * b
        }
        var x = 3 * C,
            w = 3 * (A - C) - x,
            v = 1 - x - w,
            u = 3 * B,
            t = 3 * (z - B) - u,
            s = 1 - u - t;
        return q(D, 1 / (200 * y))
    }

    function aj() {
        return this.x + aH + this.y + aH + this.width + " Ã— " + this.height
    }

    function ak() {
        return this.x + aH + this.y
    }

    function aL(h, g, l, k, j, i) {
        h != null ? (this.a = +h, this.b = +g, this.c = +l, this.d = +k, this.e = +j, this.f = +i) : (this.a = 1, this.b = 0, this.c = 0, this.d = 1, this.e = 0, this.f = 0)
    }

    function dK(T, S, R) {
        T = a8._path2curve(T), S = a8._path2curve(S);
        var Q, P, O, N, M, L, K, J, I, H, G = R ? 0 : [];
        for (var F = 0, E = T.length; F < E; F++) {
            var D = T[F];
            if (D[0] == "M") {
                Q = M = D[1], P = L = D[2]
            } else {
                D[0] == "C" ? (I = [Q, P].concat(D.slice(1)), Q = I[6], P = I[7]) : (I = [Q, P, Q, P, M, L, M, L], Q = M, P = L);
                for (var C = 0, B = S.length; C < B; C++) {
                    var A = S[C];
                    if (A[0] == "M") {
                        O = K = A[1], N = J = A[2]
                    } else {
                        A[0] == "C" ? (H = [O, N].concat(A.slice(1)), O = H[6], N = H[7]) : (H = [O, N, O, N, K, J, K, J], O = K, N = J);
                        var z = dL(I, H, R);
                        if (R) {
                            G += z
                        } else {
                            for (var y = 0, a = z.length; y < a; y++) {
                                z[y].segment1 = F, z[y].segment2 = C, z[y].bez1 = I, z[y].bez2 = H
                            }
                            G = G.concat(z)
                        }
                    }
                }
            }
        }
        return G
    }

    function dL(X, W, V) {
        var U = a8.bezierBBox(X),
            T = a8.bezierBBox(W);
        if (!a8.isBBoxIntersect(U, T)) {
            return V ? 0 : []
        }
        var S = dQ.apply(0, X),
            R = dQ.apply(0, W),
            Q = ~~(S / 5),
            P = ~~(R / 5),
            O = [],
            N = [],
            M = {},
            L = V ? 0 : [];
        for (var K = 0; K < Q + 1; K++) {
            var J = a8.findDotsAtSegment.apply(a8, X.concat(K / Q));
            O.push({
                x: J.x,
                y: J.y,
                t: K / Q
            })
        }
        for (K = 0; K < P + 1; K++) {
            J = a8.findDotsAtSegment.apply(a8, W.concat(K / P)), N.push({
                x: J.x,
                y: J.y,
                t: K / P
            })
        }
        for (K = 0; K < Q; K++) {
            for (var H = 0; H < P; H++) {
                var G = O[K],
                    F = O[K + 1],
                    E = N[H],
                    D = N[H + 1],
                    C = ao(F.x - G.x) < 0.001 ? "y" : "x",
                    B = ao(D.x - E.x) < 0.001 ? "y" : "x",
                    z = dO(G.x, G.y, F.x, F.y, E.x, E.y, D.x, D.y);
                if (z) {
                    if (M[z.x.toFixed(4)] == z.y.toFixed(4)) {
                        continue
                    }
                    M[z.x.toFixed(4)] = z.y.toFixed(4);
                    var a = G.t + ao((z[C] - G[C]) / (F[C] - G[C])) * (F.t - G.t),
                        I = E.t + ao((z[B] - E[B]) / (D[B] - E[B])) * (D.t - E.t);
                    a >= 0 && a <= 1 && I >= 0 && I <= 1 && (V ? L++ : L.push({
                        x: z.x,
                        y: z.y,
                        t1: a,
                        t2: I
                    }))
                }
            }
        }
        return L
    }

    function dM(d, c) {
        return dL(d, c, 1)
    }

    function dN(d, c) {
        return dL(d, c)
    }

    function dO(D, C, B, A, z, y, x, w) {
        if (!(at(D, B) < aq(z, x) || aq(D, B) > at(z, x) || at(C, A) < aq(y, w) || aq(C, A) > at(y, w))) {
            var v = (D * A - C * B) * (z - x) - (D - B) * (z * w - y * x),
                u = (D * A - C * B) * (y - w) - (C - A) * (z * w - y * x),
                t = (D - B) * (y - w) - (C - A) * (z - x);
            if (!t) {
                return
            }
            var s = v / t,
                r = u / t,
                q = +s.toFixed(2),
                p = +r.toFixed(2);
            if (q < +aq(D, B).toFixed(2) || q > +at(D, B).toFixed(2) || q < +aq(z, x).toFixed(2) || q > +at(z, x).toFixed(2) || p < +aq(C, A).toFixed(2) || p > +at(C, A).toFixed(2) || p < +aq(y, w).toFixed(2) || p > +at(y, w).toFixed(2)) {
                return
            }
            return {
                x: s,
                y: r
            }
        }
    }

    function dP(B, A, z, y, x, w, v, u, t) {
        if (!(t < 0 || dQ(B, A, z, y, x, w, v, u) < t)) {
            var s = 1,
                r = s / 2,
                q = s - r,
                p, o = 0.01;
            p = dQ(B, A, z, y, x, w, v, u, q);
            while (ao(p - t) > o) {
                r /= 2, q += (p < t ? 1 : -1) * r, p = dQ(B, A, z, y, x, w, v, u, q)
            }
            return q
        }
    }

    function dQ(L, K, J, I, H, G, F, E, D) {
        D == null && (D = 1), D = D > 1 ? 1 : D < 0 ? 0 : D;
        var C = D / 2,
            B = 12,
            A = [-0.1252, 0.1252, -0.3678, 0.3678, -0.5873, 0.5873, -0.7699, 0.7699, -0.9041, 0.9041, -0.9816, 0.9816],
            z = [0.2491, 0.2491, 0.2335, 0.2335, 0.2032, 0.2032, 0.1601, 0.1601, 0.1069, 0.1069, 0.0472, 0.0472],
            y = 0;
        for (var x = 0; x < B; x++) {
            var w = C * A[x] + C,
                v = dR(w, L, J, H, F),
                u = dR(w, K, I, G, E),
                t = v * v + u * u;
            y += z[x] * av.sqrt(t)
        }
        return C * y
    }

    function dR(i, h, n, m, l) {
        var k = -3 * h + 9 * n - 9 * m + 3 * l,
            j = i * k + 6 * h - 12 * n + 6 * m;
        return i * j - 3 * h + 3 * n
    }

    function aW(h, g) {
        var l = [];
        for (var k = 0, j = h.length; j - 2 * !g > k; k += 2) {
            var i = [{
                x: +h[k - 2],
                y: +h[k - 1]
            }, {


                x: +h[k],
                y: +h[k + 1]
            }, {
                x: +h[k + 2],
                y: +h[k + 3]
            }, {
                x: +h[k + 4],
                y: +h[k + 5]
            }];
            g ? k ? j - 4 == k ? i[3] = {
                x: +h[0],
                y: +h[1]
            } : j - 2 == k && (i[2] = {
                x: +h[0],
                y: +h[1]
            }, i[3] = {
                x: +h[2],
                y: +h[3]
            }) : i[0] = {
                x: +h[j - 2],
                y: +h[j - 1]
            } : j - 4 == k ? i[3] = i[2] : k || (i[0] = {
                x: +h[k],
                y: +h[k + 1]
            }), l.push(["C", (-i[0].x + 6 * i[1].x + i[2].x) / 6, (-i[0].y + 6 * i[1].y + i[2].y) / 6, (i[1].x + 6 * i[2].x - i[3].x) / 6, (i[1].y + 6 * i[2].y - i[3].y) / 6, i[2].x, i[2].y])
        }
        return l
    }

    function aY() {
        return this.hex
    }

    function a2(f, e, h) {
        function g() {
            var d = Array.prototype.slice.call(arguments, 0),
                c = d.join("â€"),
                b = g.cache = g.cache || {},
                a = g.count = g.count || [];
            if (b[aV](c)) {
                a4(a, c);
                return h ? h(b[c]) : b[c]
            }
            a.length >= 1000 && delete b[a.shift()], a.push(c), b[c] = f[aO](e, d);
            return h ? h(b[c]) : b[c]
        }
        return g
    }

    function a4(f, e) {
        for (var h = 0, g = f.length; h < g; h++) {
            if (f[h] === e) {
                return f.push(f.splice(h, 1)[0])
            }
        }
    }

    function b5(e) {
        if (Object(e) !== e) {
            return e
        }
        var d = new e.constructor;
        for (var f in e) {
            e[aV](f) && (d[f] = b5(e[f]))
        }
        return d
    }

    function a8(f) {
        if (a8.is(f, "function")) {
            return a6 ? f() : eve.on("raphael.DOMload", f)
        }
        if (a8.is(f, dr)) {
            return a8._engine.create[aO](a8, f.splice(0, 3 + a8.is(f[0], dv))).add(f)
        }
        var b = Array.prototype.slice.call(arguments, 0);
        if (a8.is(b[b.length - 1], "function")) {
            var a = b.pop();
            return a6 ? a.call(a8._engine.create[aO](a8, b)) : eve.on("raphael.DOMload", function() {
                a.call(a8._engine.create[aO](a8, b))
            })
        }
        return a8._engine.create[aO](a8, arguments)
    }
    a8.version = "2.1.0", a8.eve = eve;
    var a6, a3 = /[, ]+/,
        a1 = {
            circle: 1,
            rect: 1,
            path: 1,
            ellipse: 1,
            text: 1,
            image: 1
        },
        a0 = /\{(\d+)\}/g,
        aX = "prototype",
        aV = "hasOwnProperty",
        aU = {
            doc: document,
            win: window
        },
        aS = {
            was: Object.prototype[aV].call(aU.win, "Raphael"),
            is: aU.win.Raphael
        },
        aR = function() {
            this.ca = this.customAttributes = {}
        },
        aQ, aP = "appendChild",
        aO = "apply",
        aN = "concat",
        aK = "createTouch" in aU.doc,
        aJ = "",
        aH = " ",
        aF = String,
        aD = "split",
        aB = "click dblclick mousedown mousemove mouseout mouseover mouseup touchstart touchmove touchend touchcancel" [aD](aH),
        az = {
            mousedown: "touchstart",
            mousemove: "touchmove",
            mouseup: "touchend"
        },
        ax = aF.prototype.toLowerCase,
        av = Math,
        at = av.max,
        aq = av.min,
        ao = av.abs,
        dz = av.pow,
        dx = av.PI,
        dv = "number",
        dt = "string",
        dr = "array",
        dp = "toString",
        dm = "fill",
        dk = Object.prototype.toString,
        di = {},
        dh = "push",
        dg = a8._ISURL = /^url\(['"]?([^\)]+?)['"]?\)$/i,
        df = /^\s*((#[a-f\d]{6})|(#[a-f\d]{3})|rgba?\(\s*([\d\.]+%?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+%?(?:\s*,\s*[\d\.]+%?)?)\s*\)|hsba?\(\s*([\d\.]+(?:deg|\xb0|%)?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+(?:%?\s*,\s*[\d\.]+)?)%?\s*\)|hsla?\(\s*([\d\.]+(?:deg|\xb0|%)?\s*,\s*[\d\.]+%?\s*,\s*[\d\.]+(?:%?\s*,\s*[\d\.]+)?)%?\s*\))\s*$/i,
        de = {
            NaN: 1,
            Infinity: 1,
            "-Infinity": 1
        },
        dc = /^(?:cubic-)?bezier\(([^,]+),([^,]+),([^,]+),([^\)]+)\)/,
        da = av.round,
        c7 = "setAttribute",
        c4 = parseFloat,
        c1 = parseInt,
        cY = aF.prototype.toUpperCase,
        cV = a8._availableAttrs = {
            "arrow-end": "none",
            "arrow-start": "none",
            blur: 0,
            "clip-rect": "0 0 1e9 1e9",
            cursor: "default",
            cx: 0,
            cy: 0,
            fill: "#fff",
            "fill-opacity": 1,
            font: '10px "Arial"',
            "font-family": '"Arial"',
            "font-size": "10",
            "font-style": "normal",
            "font-weight": 400,
            gradient: 0,
            height: 0,
            href: "http://raphaeljs.com/",
            "letter-spacing": 0,
            opacity: 1,
            path: "M0,0",
            r: 0,
            rx: 0,
            ry: 0,
            src: "",
            stroke: "#000",
            "stroke-dasharray": "",
            "stroke-linecap": "butt",
            "stroke-linejoin": "butt",
            "stroke-miterlimit": 0,
            "stroke-opacity": 1,
            "stroke-width": 1,
            target: "_blank",
            "text-anchor": "middle",
            title: "Raphael",
            transform: "",
            width: 0,
            x: 0,
            y: 0
        },
        cS = a8._availableAnimAttrs = {
            blur: dv,
            "clip-rect": "csv",
            cx: dv,
            cy: dv,
            fill: "colour",
            "fill-opacity": dv,
            "font-size": dv,
            height: dv,
            opacity: dv,
            path: "path",
            r: dv,
            rx: dv,
            ry: dv,
            stroke: "colour",
            "stroke-opacity": dv,
            "stroke-width": dv,
            transform: "transform",
            width: dv,
            x: dv,
            y: dv
        },
        cP = /[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]/g,
        cM = /[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*/,
        cK = {
            hs: 1,
            rg: 1
        },
        b9 = /,?([achlmqrstvxz]),?/gi,
        b7 = /([achlmrqstvz])[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029,]*((-?\d*\.?\d*(?:e[\-+]?\d+)?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*)+)/ig,
        dS = /([rstm])[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029,]*((-?\d*\.?\d*(?:e[\-+]?\d+)?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*)+)/ig,
        b1 = /(-?\d*\.?\d*(?:e[\-+]?\d+)?)[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,?[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*/ig,
        c9 = a8._radial_gradient = /^r(?:\(([^,]+?)[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*,[\x09\x0a\x0b\x0c\x0d\x20\xa0\u1680\u180e\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u202f\u205f\u3000\u2028\u2029]*([^\)]+?)\))?/,
        c5 = {},
        c2 = function(d, c) {
            return d.key - c.key
        },
        cZ = function(d, c) {
            return c4(d) - c4(c)
        },
        cW = function() {},
        cU = function(b) {
            return b
        },
        cR = a8._rectPath = function(g, f, j, i, h) {
            if (h) {
                return [
                    ["M", g + h, f],
                    ["l", j - h * 2, 0],
                    ["a", h, h, 0, 0, 1, h, h],
                    ["l", 0, i - h * 2],
                    ["a", h, h, 0, 0, 1, -h, h],
                    ["l", h * 2 - j, 0],
                    ["a", h, h, 0, 0, 1, -h, -h],
                    ["l", 0, h * 2 - i],
                    ["a", h, h, 0, 0, 1, h, -h],
                    ["z"]
                ]
            }
            return [
                ["M", g, f],
                ["l", j, 0],
                ["l", 0, i],
                ["l", -j, 0],
                ["z"]
            ]
        },
        cO = function(f, e, h, g) {
            g == null && (g = h);
            return [
                ["M", f, e],
                ["m", 0, -g],
                ["a", h, g, 0, 1, 1, 0, 2 * g],
                ["a", h, g, 0, 1, 1, 0, -2 * g],
                ["z"]
            ]
        },
        cL = a8._getPath = {
            path: function(b) {
                return b.attr("path")
            },
            circle: function(d) {
                var c = d.attrs;
                return cO(c.cx, c.cy, c.r)
            },
            ellipse: function(d) {
                var c = d.attrs;
                return cO(c.cx, c.cy, c.rx, c.ry)
            },
            rect: function(d) {
                var c = d.attrs;
                return cR(c.x, c.y, c.width, c.height, c.r)
            },
            image: function(d) {
                var c = d.attrs;
                return cR(c.x, c.y, c.width, c.height)
            },
            text: function(d) {
                var c = d._getBBox();
                return cR(c.x, c.y, c.width, c.height)
            }
        },
        cJ = a8.mapPath = function(r, q) {
            if (!q) {
                return r
            }
            var p, o, n, m, l, k, j;
            r = dA(r);
            for (n = 0, l = r.length; n < l; n++) {
                j = r[n];
                for (m = 1, k = j.length; m < k; m += 2) {
                    p = q.x(j[m], j[m + 1]), o = q.y(j[m], j[m + 1]), j[m] = p, j[m + 1] = o
                }
            }
            return r
        };
    a8._g = aU, a8.type = aU.win.SVGAngle || aU.doc.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1") ? "SVG" : "VML";
    if (a8.type == "VML") {
        var b8 = aU.doc.createElement("div"),
            b6;
        b8.innerHTML = '<v:shape adj="1"/>', b6 = b8.firstChild, b6.style.behavior = "url(#default#VML)";
        if (!b6 || typeof b6.adj != "object") {
            return a8.type = aJ
        }
        b8 = null
    }
    a8.svg = !(a8.vml = a8.type == "VML"), a8._Paper = aR, a8.fn = aQ = aR.prototype = a8.prototype, a8._id = 0, a8._oid = 0, a8.is = function(d, c) {
        c = ax.call(c);
        if (c == "finite") {
            return !de[aV](+d)
        }
        if (c == "array") {
            return d instanceof Array
        }
        return c == "null" && d === null || c == typeof d && d !== null || c == "object" && d === Object(d) || c == "array" && Array.isArray && Array.isArray(d) || dk.call(d).slice(8, -1).toLowerCase() == c
    }, a8.angle = function(a, p, o, n, m, l) {
        if (m == null) {
            var k = a - o,
                j = p - n;
            if (!k && !j) {
                return 0
            }
            return (180 + av.atan2(-j, -k) * 180 / dx + 360) % 360
        }
        return a8.angle(a, p, m, l) - a8.angle(o, n, m, l)
    }, a8.rad = function(b) {
        return b % 360 * dx / 180
    }, a8.deg = function(b) {
        return b * 180 / dx % 360
    }, a8.snapTo = function(a, j, i) {
        i = a8.is(i, "finite") ? i : 10;
        if (a8.is(a, dr)) {
            var h = a.length;
            while (h--) {
                if (ao(a[h] - j) <= i) {
                    return a[h]
                }
            }
        } else {
            a = +a;
            var g = j % a;
            if (g < i) {
                return j - g
            }
            if (g > a - i) {
                return j - g + a
            }
        }
        return j
    };
    var b4 = a8.createUUID = function(d, c) {
        return function() {
            return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(d, c).toUpperCase()
        }
    }(/[xy]/g, function(e) {
        var d = av.random() * 16 | 0,
            f = e == "x" ? d : d & 3 | 8;
        return f.toString(16)
    });
    a8.setWindow = function(a) {
        eve("raphael.setWindow", a8, aU.win, a), aU.win = a, aU.doc = aU.win.document, a8._engine.initWin && a8._engine.initWin(aU.win)
    };
    var b3 = function(a) {
            if (a8.vml) {
                var n = /^\s+|\s+$/g,
                    m;
                try {
                    var l = new ActiveXObject("htmlfile");
                    l.write("<body>"), l.close(), m = l.body
                } catch (k) {
                    m = createPopup().document.body
                }
                var j = m.createTextRange();
                b3 = a2(function(d) {
                    try {
                        m.style.color = aF(d).replace(n, aJ);
                        var c = j.queryCommandValue("ForeColor");
                        c = (c & 255) << 16 | c & 65280 | (c & 16711680) >>> 16;
                        return "#" + ("000000" + c.toString(16)).slice(-6)
                    } catch (f) {
                        return "none"
                    }
                })
            } else {
                var h = aU.doc.createElement("i");
                h.title = "RaphaÃ«l Colour Picker", h.style.display = "none", aU.doc.body.appendChild(h), b3 = a2(function(b) {
                    h.style.color = b;
                    return aU.doc.defaultView.getComputedStyle(h, aJ).getPropertyValue("color")
                })
            }
            return b3(a)
        },
        b2 = function() {
            return "hsb(" + [this.h, this.s, this.b] + ")"
        },
        b0 = function() {
            return "hsl(" + [this.h, this.s, this.l] + ")"
        },
        a9 = function() {
            return this.hex
        },
        a7 = function(a, h, g) {
            h == null && a8.is(a, "object") && "r" in a && "g" in a && "b" in a && (g = a.b, h = a.g, a = a.r);
            if (h == null && a8.is(a, dt)) {
                var f = a8.getRGB(a);
                a = f.r, h = f.g, g = f.b
            }
            if (a > 1 || h > 1 || g > 1) {
                a /= 255, h /= 255, g /= 255
            }
            return [a, h, g]
        },
        a5 = function(a, j, i, h) {
            a *= 255, j *= 255, i *= 255;
            var g = {
                r: a,
                g: j,
                b: i,
                hex: a8.rgb(a, j, i),
                toString: a9
            };
            a8.is(h, "finite") && (g.opacity = h);
            return g
        };
    a8.color = function(a) {
        var d;
        a8.is(a, "object") && "h" in a && "s" in a && "b" in a ? (d = a8.hsb2rgb(a), a.r = d.r, a.g = d.g, a.b = d.b, a.hex = d.hex) : a8.is(a, "object") && "h" in a && "s" in a && "l" in a ? (d = a8.hsl2rgb(a), a.r = d.r, a.g = d.g, a.b = d.b, a.hex = d.hex) : (a8.is(a, "string") && (a = a8.getRGB(a)), a8.is(a, "object") && "r" in a && "g" in a && "b" in a ? (d = a8.rgb2hsl(a), a.h = d.h, a.s = d.s, a.l = d.l, d = a8.rgb2hsb(a), a.v = d.b) : (a = {
            hex: "none"
        }, a.r = a.g = a.b = a.h = a.s = a.v = a.l = -1)), a.toString = a9;
        return a
    }, a8.hsb2rgb = function(r, q, p, o) {
        this.is(r, "object") && "h" in r && "s" in r && "b" in r && (p = r.b, q = r.s, r = r.h, o = r.o), r *= 360;
        var n, m, l, k, j;
        r = r % 360 / 60, j = p * q, k = j * (1 - ao(r % 2 - 1)), n = m = l = p - j, r = ~~r, n += [j, k, 0, 0, k, j][r], m += [k, j, j, k, 0, 0][r], l += [0, 0, k, j, j, k][r];
        return a5(n, m, l, o)
    }, a8.hsl2rgb = function(r, q, p, o) {
        this.is(r, "object") && "h" in r && "s" in r && "l" in r && (p = r.l, q = r.s, r = r.h);
        if (r > 1 || q > 1 || p > 1) {
            r /= 360, q /= 100, p /= 100
        }
        r *= 360;
        var n, m, l, k, j;
        r = r % 360 / 60, j = 2 * q * (p < 0.5 ? p : 1 - p), k = j * (1 - ao(r % 2 - 1)), n = m = l = p - j / 2, r = ~~r, n += [j, k, 0, 0, k, j][r], m += [k, j, j, k, 0, 0][r], l += [0, 0, k, j, j, k][r];
        return a5(n, m, l, o)
    }, a8.rgb2hsb = function(i, h, n) {
        n = a7(i, h, n), i = n[0], h = n[1], n = n[2];
        var m, l, k, j;
        k = at(i, h, n), j = k - aq(i, h, n), m = j == 0 ? null : k == i ? (h - n) / j : k == h ? (n - i) / j + 2 : (i - h) / j + 4, m = (m + 360) % 6 * 60 / 360, l = j == 0 ? 0 : j / k;
        return {
            h: m,
            s: l,
            b: k,
            toString: b2
        }
    }, a8.rgb2hsl = function(r, q, p) {
        p = a7(r, q, p), r = p[0], q = p[1], p = p[2];
        var o, n, m, l, k, j;
        l = at(r, q, p), k = aq(r, q, p), j = l - k, o = j == 0 ? null : l == r ? (q - p) / j : l == q ? (p - r) / j + 2 : (r - q) / j + 4, o = (o + 360) % 6 * 60 / 360, m = (l + k) / 2, n = j == 0 ? 0 : m < 0.5 ? j / (2 * m) : j / (2 - 2 * m);
        return {
            h: o,
            s: n,
            l: m,
            toString: b0
        }
    }, a8._path2string = function() {
        return this.join(",").replace(b9, "$1")
    };
    var aZ = a8._preload = function(e, d) {
        var f = aU.doc.createElement("img");
        f.style.cssText = "position:absolute;left:-9999em;top:-9999em", f.onload = function() {
            d.call(this), this.onload = null, aU.doc.body.removeChild(this)
        }, f.onerror = function() {
            aU.doc.body.removeChild(this)
        }, aU.doc.body.appendChild(f), f.src = e
    };
    a8.getRGB = a2(function(r) {
        if (!r || !!((r = aF(r)).indexOf("-") + 1)) {
            return {
                r: -1,
                g: -1,
                b: -1,
                hex: "none",
                error: 1,
                toString: aY
            }
        }
        if (r == "none") {
            return {
                r: -1,
                g: -1,
                b: -1,
                hex: "none",
                toString: aY
            }
        }!cK[aV](r.toLowerCase().substring(0, 2)) && r.charAt() != "#" && (r = b3(r));
        var q, p, o, n, m, l, g, a = r.match(df);
        if (a) {
            a[2] && (n = c1(a[2].substring(5), 16), o = c1(a[2].substring(3, 5), 16), p = c1(a[2].substring(1, 3), 16)), a[3] && (n = c1((l = a[3].charAt(3)) + l, 16), o = c1((l = a[3].charAt(2)) + l, 16), p = c1((l = a[3].charAt(1)) + l, 16)), a[4] && (g = a[4][aD](cM), p = c4(g[0]), g[0].slice(-1) == "%" && (p *= 2.55), o = c4(g[1]), g[1].slice(-1) == "%" && (o *= 2.55), n = c4(g[2]), g[2].slice(-1) == "%" && (n *= 2.55), a[1].toLowerCase().slice(0, 4) == "rgba" && (m = c4(g[3])), g[3] && g[3].slice(-1) == "%" && (m /= 100));
            if (a[5]) {
                g = a[5][aD](cM), p = c4(g[0]), g[0].slice(-1) == "%" && (p *= 2.55), o = c4(g[1]), g[1].slice(-1) == "%" && (o *= 2.55), n = c4(g[2]), g[2].slice(-1) == "%" && (n *= 2.55), (g[0].slice(-3) == "deg" || g[0].slice(-1) == "Â°") && (p /= 360), a[1].toLowerCase().slice(0, 4) == "hsba" && (m = c4(g[3])), g[3] && g[3].slice(-1) == "%" && (m /= 100);
                return a8.hsb2rgb(p, o, n, m)
            }
            if (a[6]) {
                g = a[6][aD](cM), p = c4(g[0]), g[0].slice(-1) == "%" && (p *= 2.55), o = c4(g[1]), g[1].slice(-1) == "%" && (o *= 2.55), n = c4(g[2]), g[2].slice(-1) == "%" && (n *= 2.55), (g[0].slice(-3) == "deg" || g[0].slice(-1) == "Â°") && (p /= 360), a[1].toLowerCase().slice(0, 4) == "hsla" && (m = c4(g[3])), g[3] && g[3].slice(-1) == "%" && (m /= 100);
                return a8.hsl2rgb(p, o, n, m)
            }
            a = {
                r: p,
                g: o,
                b: n,
                toString: aY
            }, a.hex = "#" + (16777216 | n | o << 8 | p << 16).toString(16).slice(1), a8.is(m, "finite") && (a.opacity = m);
            return a
        }
        return {
            r: -1,
            g: -1,
            b: -1,
            hex: "none",
            error: 1,
            toString: aY
        }
    }, a8), a8.hsb = a2(function(a, f, e) {
        return a8.hsb2rgb(a, f, e).hex
    }), a8.hsl = a2(function(a, f, e) {
        return a8.hsl2rgb(a, f, e).hex
    }), a8.rgb = a2(function(e, d, f) {
        return "#" + (16777216 | f | d << 8 | e << 16).toString(16).slice(1)
    }), a8.getColor = function(e) {
        var d = this.getColor.start = this.getColor.start || {
                h: 0,
                s: 1,
                b: e || 0.75
            },
            f = this.hsb2rgb(d.h, d.s, d.b);
        d.h += 0.075, d.h > 1 && (d.h = 0, d.s -= 0.2, d.s <= 0 && (this.getColor.start = {
            h: 0,
            s: 1,
            b: d.b
        }));
        return f.hex
    }, a8.getColor.reset = function() {
        delete this.start
    }, a8.parsePathString = function(a) {
        if (!a) {
            return null
        }
        var h = aT(a);
        if (h.arr) {
            return dI(h.arr)
        }
        var g = {
                a: 7,
                c: 6,
                h: 1,
                l: 2,
                m: 2,
                r: 4,
                q: 4,
                s: 4,
                t: 2,
                v: 1,
                z: 0
            },
            f = [];
        a8.is(a, dr) && a8.is(a[0], dr) && (f = dI(a)), f.length || aF(a).replace(b7, function(e, d, k) {
            var j = [],
                i = d.toLowerCase();
            k.replace(b1, function(l, c) {
                c && j.push(+c)
            }), i == "m" && j.length > 2 && (f.push([d][aN](j.splice(0, 2))), i = "l", d = d == "m" ? "l" : "L");
            if (i == "r") {
                f.push([d][aN](j))
            } else {
                while (j.length >= g[i]) {
                    f.push([d][aN](j.splice(0, g[i])));
                    if (!g[i]) {
                        break
                    }
                }
            }
        }), f.toString = a8._path2string, h.arr = dI(f);
        return f
    }, a8.parseTransformString = a2(function(a) {
        if (!a) {
            return null
        }
        var f = {
                r: 3,
                s: 4,
                t: 2,
                m: 6
            },
            e = [];
        a8.is(a, dr) && a8.is(a[0], dr) && (e = dI(a)), e.length || aF(a).replace(dS, function(g, d, j) {
            var i = [],
                h = ax.call(d);
            j.replace(b1, function(k, c) {
                c && i.push(+c)
            }), e.push([d][aN](i))
        }), e.toString = a8._path2string;
        return e
    });
    var aT = function(d) {
        var c = aT.ps = aT.ps || {};
        c[d] ? c[d].sleep = 100 : c[d] = {
            sleep: 100
        }, setTimeout(function() {
            for (var a in c) {
                c[aV](a) && a != d && (c[a].sleep--, !c[a].sleep && delete c[a])
            }
        });
        return c[d]
    };
    a8.findDotsAtSegment = function(X, W, V, U, T, S, R, Q, P) {
        var O = 1 - P,
            N = dz(O, 3),
            M = dz(O, 2),
            L = P * P,
            K = L * P,
            J = N * X + M * 3 * P * V + O * 3 * P * P * T + K * R,
            I = N * W + M * 3 * P * U + O * 3 * P * P * S + K * Q,
            H = X + 2 * P * (V - X) + L * (T - 2 * V + X),
            G = W + 2 * P * (U - W) + L * (S - 2 * U + W),
            F = V + 2 * P * (T - V) + L * (R - 2 * T + V),
            E = U + 2 * P * (S - U) + L * (Q - 2 * S + U),
            D = O * X + P * V,
            C = O * W + P * U,
            B = O * T + P * R,
            A = O * S + P * Q,
            w = 90 - av.atan2(H - F, G - E) * 180 / dx;
        (H > F || G < E) && (w += 180);
        return {
            x: J,
            y: I,
            m: {
                x: H,
                y: G
            },
            n: {
                x: F,
                y: E
            },
            start: {
                x: D,
                y: C
            },
            end: {
                x: B,
                y: A
            },
            alpha: w
        }
    }, a8.bezierBBox = function(r, q, p, o, n, m, l, k) {
        a8.is(r, "array") || (r = [r, q, p, o, n, m, l, k]);
        var a = dB.apply(null, r);
        return {
            x: a.min.x,
            y: a.min.y,
            x2: a.max.x,
            y2: a.max.y,
            width: a.max.x - a.min.x,
            height: a.max.y - a.min.y
        }
    }, a8.isPointInsideBBox = function(e, d, f) {
        return d >= e.x && d <= e.x2 && f >= e.y && f <= e.y2
    }, a8.isBBoxIntersect = function(a, f) {
        var e = a8.isPointInsideBBox;
        return e(f, a.x, a.y) || e(f, a.x2, a.y) || e(f, a.x, a.y2) || e(f, a.x2, a.y2) || e(a, f.x, f.y) || e(a, f.x2, f.y) || e(a, f.x, f.y2) || e(a, f.x2, f.y2) || (a.x < f.x2 && a.x > f.x || f.x < a.x2 && f.x > a.x) && (a.y < f.y2 && a.y > f.y || f.y < a.y2 && f.y > a.y)
    }, a8.pathIntersection = function(d, c) {
        return dK(d, c)
    }, a8.pathIntersectionNumber = function(d, c) {
        return dK(d, c, 1)
    }, a8.isPointInsidePath = function(a, h, g) {
        var f = a8.pathBBox(a);
        return a8.isPointInsideBBox(f, h, g) && dK(a, [
            ["M", h, g],
            ["H", f.x2 + 10]
        ], 1) % 2 == 1
    }, a8._removedFactory = function(b) {
        return function() {
            eve("raphael.log", null, "RaphaÃ«l: you are calling to method â€œ" + b + "â€ of removed object", b)
        }
    };
    var dJ = a8.pathBBox = function(D) {
            var C = aT(D);
            if (C.bbox) {
                return C.bbox
            }
            if (!D) {
                return {
                    x: 0,
                    y: 0,
                    width: 0,
                    height: 0,
                    x2: 0,
                    y2: 0
                }
            }
            D = dA(D);
            var B = 0,
                A = 0,
                z = [],
                y = [],
                x;
            for (var w = 0, v = D.length; w < v; w++) {
                x = D[w];
                if (x[0] == "M") {
                    B = x[1], A = x[2], z.push(B), y.push(A)
                } else {
                    var u = dB(B, A, x[1], x[2], x[3], x[4], x[5], x[6]);
                    z = z[aN](u.min.x, u.max.x), y = y[aN](u.min.y, u.max.y), B = x[5], A = x[6]
                }
            }
            var t = aq[aO](0, z),
                s = aq[aO](0, y),
                r = at[aO](0, z),
                n = at[aO](0, y),
                m = {
                    x: t,
                    y: s,
                    x2: r,
                    y2: n,
                    width: r - t,
                    height: n - s
                };
            C.bbox = b5(m);
            return m
        },
        dI = function(a) {
            var d = b5(a);
            d.toString = a8._path2string;
            return d
        },
        dH = a8._pathToRelative = function(H) {
            var G = aT(H);
            if (G.rel) {
                return dI(G.rel)
            }
            if (!a8.is(H, dr) || !a8.is(H && H[0], dr)) {
                H = a8.parsePathString(H)
            }
            var F = [],
                E = 0,
                D = 0,
                C = 0,
                B = 0,
                A = 0;
            H[0][0] == "M" && (E = H[0][1], D = H[0][2], C = E, B = D, A++, F.push(["M", E, D]));
            for (var z = A, y = H.length; z < y; z++) {
                var x = F[z] = [],
                    w = H[z];
                if (w[0] != ax.call(w[0])) {
                    x[0] = ax.call(w[0]);
                    switch (x[0]) {
                        case "a":
                            x[1] = w[1], x[2] = w[2], x[3] = w[3], x[4] = w[4], x[5] = w[5], x[6] = +(w[6] - E).toFixed(3), x[7] = +(w[7] - D).toFixed(3);
                            break;
                        case "v":
                            x[1] = +(w[1] - D).toFixed(3);
                            break;
                        case "m":
                            C = w[1], B = w[2];
                        default:
                            for (var v = 1, u = w.length; v < u; v++) {
                                x[v] = +(w[v] - (v % 2 ? E : D)).toFixed(3)
                            }
                    }
                } else {
                    x = F[z] = [], w[0] == "m" && (C = w[1] + E, B = w[2] + D);
                    for (var t = 0, s = w.length; t < s; t++) {
                        F[z][t] = w[t]
                    }
                }
                var a = F[z].length;
                switch (F[z][0]) {
                    case "z":
                        E = C, D = B;
                        break;
                    case "h":
                        E += +F[z][a - 1];
                        break;
                    case "v":
                        D += +F[z][a - 1];
                        break;
                    default:
                        E += +F[z][a - 2], D += +F[z][a - 1]
                }
            }
            F.toString = a8._path2string, G.rel = dI(F);
            return F
        },
        dG = a8._pathToAbsolute = function(J) {
            var I = aT(J);
            if (I.abs) {
                return dI(I.abs)
            }
            if (!a8.is(J, dr) || !a8.is(J && J[0], dr)) {
                J = a8.parsePathString(J)
            }
            if (!J || !J.length) {
                return [
                    ["M", 0, 0]
                ]
            }
            var H = [],
                G = 0,
                F = 0,
                E = 0,
                D = 0,
                C = 0;
            J[0][0] == "M" && (G = +J[0][1], F = +J[0][2], E = G, D = F, C++, H[0] = ["M", G, F]);
            var B = J.length == 3 && J[0][0] == "M" && J[1][0].toUpperCase() == "R" && J[2][0].toUpperCase() == "Z";
            for (var A, z, y = C, x = J.length; y < x; y++) {
                H.push(A = []), z = J[y];
                if (z[0] != cY.call(z[0])) {
                    A[0] = cY.call(z[0]);
                    switch (A[0]) {
                        case "A":
                            A[1] = z[1], A[2] = z[2], A[3] = z[3], A[4] = z[4], A[5] = z[5], A[6] = +(z[6] + G), A[7] = +(z[7] + F);
                            break;
                        case "V":
                            A[1] = +z[1] + F;
                            break;
                        case "H":
                            A[1] = +z[1] + G;
                            break;
                        case "R":
                            var w = [G, F][aN](z.slice(1));
                            for (var v = 2, u = w.length; v < u; v++) {
                                w[v] = +w[v] + G, w[++v] = +w[v] + F
                            }

                            H.pop(), H = H[aN](aW(w, B));
                            break;
                        case "M":
                            E = +z[1] + G, D = +z[2] + F;
                        default:
                            for (v = 1, u = z.length; v < u; v++) {
                                A[v] = +z[v] + (v % 2 ? G : F)
                            }
                    }
                } else {
                    if (z[0] == "R") {
                        w = [G, F][aN](z.slice(1)), H.pop(), H = H[aN](aW(w, B)), A = ["R"][aN](z.slice(-2))
                    } else {
                        for (var n = 0, a = z.length; n < a; n++) {
                            A[n] = z[n]
                        }
                    }
                }
                switch (A[0]) {
                    case "Z":
                        G = E, F = D;
                        break;
                    case "H":
                        G = A[1];
                        break;
                    case "V":
                        F = A[1];
                        break;
                    case "M":
                        E = A[A.length - 2], D = A[A.length - 1];
                    default:
                        G = A[A.length - 2], F = A[A.length - 1]
                }
            }
            H.toString = a8._path2string, I.abs = dI(H);
            return H
        },
        dF = function(f, e, h, g) {
            return [f, e, h, g, h, g]
        },
        dE = function(j, i, p, o, n, m) {
            var l = 1 / 3,
                k = 2 / 3;
            return [l * j + k * p, l * i + k * o, l * n + k * p, l * m + k * o, n, m]
        },
        dD = function(bL, bK, bJ, bI, bH, bG, bF, bE, bD, bC) {
            var bB = dx * 120 / 180,
                bA = dx / 180 * (+bH || 0),
                bz = [],
                by, bx = a2(function(g, f, j) {
                    var i = g * av.cos(j) - f * av.sin(j),
                        h = g * av.sin(j) + f * av.cos(j);
                    return {
                        x: i,
                        y: h
                    }
                });
            if (!bC) {
                by = bx(bL, bK, -bA), bL = by.x, bK = by.y, by = bx(bE, bD, -bA), bE = by.x, bD = by.y;
                var bw = av.cos(dx / 180 * bH),
                    bv = av.sin(dx / 180 * bH),
                    bu = (bL - bE) / 2,
                    bt = (bK - bD) / 2,
                    bs = bu * bu / (bJ * bJ) + bt * bt / (bI * bI);
                bs > 1 && (bs = av.sqrt(bs), bJ = bs * bJ, bI = bs * bI);
                var br = bJ * bJ,
                    bq = bI * bI,
                    bp = (bG == bF ? -1 : 1) * av.sqrt(ao((br * bq - br * bt * bt - bq * bu * bu) / (br * bt * bt + bq * bu * bu))),
                    bo = bp * bJ * bt / bI + (bL + bE) / 2,
                    bn = bp * -bI * bu / bJ + (bK + bD) / 2,
                    bm = av.asin(((bK - bn) / bI).toFixed(9)),
                    bl = av.asin(((bD - bn) / bI).toFixed(9));
                bm = bL < bo ? dx - bm : bm, bl = bE < bo ? dx - bl : bl, bm < 0 && (bm = dx * 2 + bm), bl < 0 && (bl = dx * 2 + bl), bF && bm > bl && (bm = bm - dx * 2), !bF && bl > bm && (bl = bl - dx * 2)
            } else {
                bm = bC[0], bl = bC[1], bo = bC[2], bn = bC[3]
            }
            var bk = bl - bm;
            if (ao(bk) > bB) {
                var bj = bl,
                    bi = bE,
                    bh = bD;
                bl = bm + bB * (bF && bl > bm ? 1 : -1), bE = bo + bJ * av.cos(bl), bD = bn + bI * av.sin(bl), bz = dD(bE, bD, bJ, bI, bH, 0, bF, bi, bh, [bl, bj, bo, bn])
            }
            bk = bl - bm;
            var bg = av.cos(bm),
                bf = av.sin(bm),
                be = av.cos(bl),
                bd = av.sin(bl),
                bc = av.tan(bk / 4),
                bb = 4 / 3 * bJ * bc,
                ba = 4 / 3 * bI * bc,
                Z = [bL, bK],
                Y = [bL + bb * bf, bK - ba * bg],
                B = [bE + bb * bd, bD - ba * be],
                z = [bE, bD];
            Y[0] = 2 * Z[0] - Y[0], Y[1] = 2 * Z[1] - Y[1];
            if (bC) {
                return [Y, B, z][aN](bz)
            }
            bz = [Y, B, z][aN](bz).join()[aD](",");
            var w = [];
            for (var s = 0, n = bz.length; s < n; s++) {
                w[s] = s % 2 ? bx(bz[s - 1], bz[s], bA).y : bx(bz[s], bz[s + 1], bA).x
            }
            return w
        },
        dC = function(t, s, r, q, p, o, n, m, l) {
            var k = 1 - l;
            return {
                x: dz(k, 3) * t + dz(k, 2) * 3 * l * r + k * 3 * l * l * p + dz(l, 3) * n,
                y: dz(k, 3) * s + dz(k, 2) * 3 * l * q + k * 3 * l * l * o + dz(l, 3) * m
            }
        },
        dB = a2(function(F, E, D, C, B, A, z, y) {
            var x = B - 2 * D + F - (z - 2 * B + D),
                w = 2 * (D - F) - 2 * (B - D),
                v = F - D,
                u = (-w + av.sqrt(w * w - 4 * x * v)) / 2 / x,
                t = (-w - av.sqrt(w * w - 4 * x * v)) / 2 / x,
                s = [E, y],
                r = [F, z],
                m;
            ao(u) > "1e12" && (u = 0.5), ao(t) > "1e12" && (t = 0.5), u > 0 && u < 1 && (m = dC(F, E, D, C, B, A, z, y, u), r.push(m.x), s.push(m.y)), t > 0 && t < 1 && (m = dC(F, E, D, C, B, A, z, y, t), r.push(m.x), s.push(m.y)), x = A - 2 * C + E - (y - 2 * A + C), w = 2 * (C - E) - 2 * (A - C), v = E - C, u = (-w + av.sqrt(w * w - 4 * x * v)) / 2 / x, t = (-w - av.sqrt(w * w - 4 * x * v)) / 2 / x, ao(u) > "1e12" && (u = 0.5), ao(t) > "1e12" && (t = 0.5), u > 0 && u < 1 && (m = dC(F, E, D, C, B, A, z, y, u), r.push(m.x), s.push(m.y)), t > 0 && t < 1 && (m = dC(F, E, D, C, B, A, z, y, t), r.push(m.x), s.push(m.y));
            return {
                min: {
                    x: aq[aO](0, r),
                    y: aq[aO](0, s)
                },
                max: {
                    x: at[aO](0, r),
                    y: at[aO](0, s)
                }
            }
        }),
        dA = a8._path2curve = a2(function(F, E) {
            var D = !E && aT(F);
            if (!E && D.curve) {
                return dI(D.curve)
            }
            var C = dG(F),
                B = E && dG(E),
                A = {
                    x: 0,
                    y: 0,
                    bx: 0,
                    by: 0,
                    X: 0,
                    Y: 0,
                    qx: null,
                    qy: null
                },
                z = {
                    x: 0,
                    y: 0,
                    bx: 0,
                    by: 0,
                    X: 0,
                    Y: 0,
                    qx: null,
                    qy: null
                },
                y = function(f, e) {
                    var h, g;
                    if (!f) {
                        return ["C", e.x, e.y, e.x, e.y, e.x, e.y]
                    }!(f[0] in {
                        T: 1,
                        Q: 1
                    }) && (e.qx = e.qy = null);
                    switch (f[0]) {
                        case "M":
                            e.X = f[1], e.Y = f[2];
                            break;
                        case "A":
                            f = ["C"][aN](dD[aO](0, [e.x, e.y][aN](f.slice(1))));
                            break;
                        case "S":
                            h = e.x + (e.x - (e.bx || e.x)), g = e.y + (e.y - (e.by || e.y)), f = ["C", h, g][aN](f.slice(1));
                            break;
                        case "T":
                            e.qx = e.x + (e.x - (e.qx || e.x)), e.qy = e.y + (e.y - (e.qy || e.y)), f = ["C"][aN](dE(e.x, e.y, e.qx, e.qy, f[1], f[2]));
                            break;
                        case "Q":
                            e.qx = f[1], e.qy = f[2], f = ["C"][aN](dE(e.x, e.y, f[1], f[2], f[3], f[4]));
                            break;
                        case "L":
                            f = ["C"][aN](dF(e.x, e.y, f[1], f[2]));
                            break;
                        case "H":
                            f = ["C"][aN](dF(e.x, e.y, f[1], e.y));
                            break;
                        case "V":
                            f = ["C"][aN](dF(e.x, e.y, e.x, f[1]));
                            break;
                        case "Z":
                            f = ["C"][aN](dF(e.x, e.y, e.X, e.Y))
                    }
                    return f
                },
                x = function(e, d) {
                    if (e[d].length > 7) {
                        e[d].shift();
                        var f = e[d];
                        while (f.length) {
                            e.splice(d++, 0, ["C"][aN](f.splice(0, 6)))
                        }
                        e.splice(d, 1), u = at(C.length, B && B.length || 0)
                    }
                },
                w = function(e, d, j, i, h) {
                    e && d && e[h][0] == "M" && d[h][0] != "M" && (d.splice(h, 0, ["M", i.x, i.y]), j.bx = 0, j.by = 0, j.x = e[h][1], j.y = e[h][2], u = at(C.length, B && B.length || 0))
                };
            for (var v = 0, u = at(C.length, B && B.length || 0); v < u; v++) {
                C[v] = y(C[v], A), x(C, v), B && (B[v] = y(B[v], z)), B && x(B, v), w(C, B, A, z, v), w(B, C, z, A, v);
                var t = C[v],
                    s = B && B[v],
                    n = t.length,
                    m = B && s.length;
                A.x = t[n - 2], A.y = t[n - 1], A.bx = c4(t[n - 4]) || A.x, A.by = c4(t[n - 3]) || A.y, z.bx = B && (c4(s[m - 4]) || z.x), z.by = B && (c4(s[m - 3]) || z.y), z.x = B && s[m - 2], z.y = B && s[m - 1]
            }
            B || (D.curve = dI(C));
            return B ? [C, B] : C
        }, null, dI),
        dy = a8._parseDots = a2(function(t) {
            var s = [];
            for (var r = 0, q = t.length; r < q; r++) {
                var p = {},
                    o = t[r].match(/^([^:]*):?([\d\.]*)/);
                p.color = a8.getRGB(o[1]);
                if (p.color.error) {
                    return null
                }
                p.color = p.color.hex, o[2] && (p.offset = o[2] + "%"), s.push(p)
            }
            for (r = 1, q = s.length - 1; r < q; r++) {
                if (!s[r].offset) {
                    var n = c4(s[r - 1].offset || 0),
                        m = 0;
                    for (var l = r + 1; l < q; l++) {
                        if (s[l].offset) {
                            m = s[l].offset;
                            break
                        }
                    }
                    m || (m = 100, l = q), m = c4(m);
                    var a = (m - n) / (l - r + 1);
                    for (; r < l; r++) {
                        n += a, s[r].offset = n + "%"
                    }
                }
            }
            return s
        }),
        dw = a8._tear = function(d, c) {
            d == c.top && (c.top = d.prev), d == c.bottom && (c.bottom = d.next), d.next && (d.next.prev = d.prev), d.prev && (d.prev.next = d.next)
        },
        du = a8._tofront = function(d, c) {
            c.top !== d && (dw(d, c), d.next = null, d.prev = c.top, c.top.next = d, c.top = d)
        },
        ds = a8._toback = function(d, c) {
            c.bottom !== d && (dw(d, c), d.next = c.bottom, d.prev = null, c.bottom.prev = d, c.bottom = d)
        },
        dq = a8._insertafter = function(e, d, f) {
            dw(e, f), d == f.top && (f.top = e), d.next && (d.next.prev = e), e.next = d.next, e.prev = d, d.next = e
        },
        dn = a8._insertbefore = function(e, d, f) {
            dw(e, f), d == f.bottom && (f.bottom = e), d.prev && (d.prev.next = e), e.prev = d.prev, d.prev = e, e.next = d
        },
        dl = a8.toMatrix = function(f, e) {
            var h = dJ(f),
                g = {
                    _: {
                        transform: aJ
                    },
                    getBBox: function() {
                        return h
                    }
                };
            dT(g, e);
            return g.matrix
        },
        dj = a8.transformPath = function(d, c) {
            return cJ(d, dl(d, c))
        },
        dT = a8._extractTransform = function(R, Q) {
            if (Q == null) {
                return R._.transform
            }
            Q = aF(Q).replace(/\.{3}|\u2026/g, R._.transform || aJ);
            var P = a8.parseTransformString(Q),
                O = 0,
                N = 0,
                M = 0,
                L = 1,
                K = 1,
                J = R._,
                I = new aL;
            J.transform = P || [];
            if (P) {
                for (var H = 0, G = P.length; H < G; H++) {
                    var F = P[H],
                        E = F.length,
                        D = aF(F[0]).toLowerCase(),
                        C = F[0] != D,
                        B = C ? I.invert() : 0,
                        A, z, r, p, a;
                    D == "t" && E == 3 ? C ? (A = B.x(0, 0), z = B.y(0, 0), r = B.x(F[1], F[2]), p = B.y(F[1], F[2]), I.translate(r - A, p - z)) : I.translate(F[1], F[2]) : D == "r" ? E == 2 ? (a = a || R.getBBox(1), I.rotate(F[1], a.x + a.width / 2, a.y + a.height / 2), O += F[1]) : E == 4 && (C ? (r = B.x(F[2], F[3]), p = B.y(F[2], F[3]), I.rotate(F[1], r, p)) : I.rotate(F[1], F[2], F[3]), O += F[1]) : D == "s" ? E == 2 || E == 3 ? (a = a || R.getBBox(1), I.scale(F[1], F[E - 1], a.x + a.width / 2, a.y + a.height / 2), L *= F[1], K *= F[E - 1]) : E == 5 && (C ? (r = B.x(F[3], F[4]), p = B.y(F[3], F[4]), I.scale(F[1], F[2], r, p)) : I.scale(F[1], F[2], F[3], F[4]), L *= F[1], K *= F[2]) : D == "m" && E == 7 && I.add(F[1], F[2], F[3], F[4], F[5], F[6]), J.dirtyT = 1, R.matrix = I
                }
            }
            R.matrix = I, J.sx = L, J.sy = K, J.deg = O, J.dx = N = I.e, J.dy = M = I.f, L == 1 && K == 1 && !O && J.bbox ? (J.bbox.x += +N, J.bbox.y += +M) : J.dirtyT = 1
        },
        dd = function(d) {
            var c = d[0];
            switch (c.toLowerCase()) {
                case "t":
                    return [c, 0, 0];
                case "m":
                    return [c, 1, 0, 0, 1, 0, 0];
                case "r":
                    return d.length == 4 ? [c, 0, d[2], d[3]] : [c, 0];
                case "s":
                    return d.length == 5 ? [c, 1, 1, d[3], d[4]] : d.length == 3 ? [c, 1, 1] : [c, 1]
            }
        },
        aM = a8._equaliseTransform = function(t, s) {
            s = aF(s).replace(/\.{3}|\u2026/g, t), t = a8.parseTransformString(t) || [], s = a8.parseTransformString(s) || [];
            var r = at(t.length, s.length),
                q = [],
                p = [],
                o = 0,
                n, m, l, a;
            for (; o < r; o++) {
                l = t[o] || dd(s[o]), a = s[o] || dd(l);
                if (l[0] != a[0] || l[0].toLowerCase() == "r" && (l[2] != a[2] || l[3] != a[3]) || l[0].toLowerCase() == "s" && (l[3] != a[3] || l[4] != a[4])) {
                    return
                }
                q[o] = [], p[o] = [];
                for (n = 0, m = at(l.length, a.length); n < m; n++) {
                    n in l && (q[o][n] = l[n]), n in a && (p[o][n] = a[n])
                }
            }
            return {
                from: q,
                to: p
            }
        };
    a8._getContainer = function(a, j, i, h) {
            var g;
            g = h == null && !a8.is(a, "object") ? aU.doc.getElementById(a) : a;
            if (g != null) {
                if (g.tagName) {
                    return j == null ? {
                        container: g,
                        width: g.style.pixelWidth || g.offsetWidth,
                        height: g.style.pixelHeight || g.offsetHeight
                    } : {
                        container: g,
                        width: j,
                        height: i
                    }
                }
                return {
                    container: 1,
                    x: a,
                    y: j,
                    width: i,
                    height: h
                }
            }
        }, a8.pathToRelative = dH, a8._engine = {}, a8.path2curve = dA, a8.matrix = function(h, g, l, k, j, i) {
            return new aL(h, g, l, k, j, i)
        },
        function(a) {
            function e(d) {
                var c = av.sqrt(f(d));
                d[0] && (d[0] /= c), d[1] && (d[1] /= c)
            }

            function f(b) {
                return b[0] * b[0] + b[1] * b[1]
            }
            a.add = function(z, y, x, w, v, u) {
                var t = [
                        [],
                        [],
                        []
                    ],
                    s = [
                        [this.a, this.c, this.e],
                        [this.b, this.d, this.f],
                        [0, 0, 1]
                    ],
                    r = [
                        [z, x, v],
                        [y, w, u],
                        [0, 0, 1]
                    ],
                    q, p, o, n;
                z && z instanceof aL && (r = [
                    [z.a, z.c, z.e],
                    [z.b, z.d, z.f],
                    [0, 0, 1]
                ]);
                for (q = 0; q < 3; q++) {
                    for (p = 0; p < 3; p++) {
                        n = 0;
                        for (o = 0; o < 3; o++) {
                            n += s[q][o] * r[o][p]
                        }
                        t[q][p] = n
                    }
                }
                this.a = t[0][0], this.b = t[1][0], this.c = t[0][1], this.d = t[1][1], this.e = t[0][2], this.f = t[1][2]
            }, a.invert = function() {
                var d = this,
                    c = d.a * d.d - d.b * d.c;
                return new aL(d.d / c, -d.b / c, -d.c / c, d.a / c, (d.c * d.f - d.d * d.e) / c, (d.b * d.e - d.a * d.f) / c)
            }, a.clone = function() {
                return new aL(this.a, this.b, this.c, this.d, this.e, this.f)
            }, a.translate = function(d, c) {
                this.add(1, 0, 0, 1, d, c)
            }, a.scale = function(h, g, j, i) {
                g == null && (g = h), (j || i) && this.add(1, 0, 0, 1, j, i), this.add(h, 0, 0, g, 0, 0), (j || i) && this.add(1, 0, 0, 1, -j, -i)
            }, a.rotate = function(g, k, j) {
                g = a8.rad(g), k = k || 0, j = j || 0;
                var i = +av.cos(g).toFixed(9),
                    h = +av.sin(g).toFixed(9);
                this.add(i, h, -h, i, k, j), this.add(1, 0, 0, 1, -k, -j)
            }, a.x = function(d, c) {
                return d * this.a + c * this.c + this.e
            }, a.y = function(d, c) {
                return d * this.b + c * this.d + this.f
            }, a.get = function(b) {
                return +this[aF.fromCharCode(97 + b)].toFixed(4)
            }, a.toString = function() {
                return a8.svg ? "matrix(" + [this.get(0), this.get(1), this.get(2), this.get(3), this.get(4), this.get(5)].join() + ")" : [this.get(0), this.get(2), this.get(1), this.get(3), 0, 0].join()
            }, a.toFilter = function() {
                return "progid:DXImageTransform.Microsoft.Matrix(M11=" + this.get(0) + ", M12=" + this.get(2) + ", M21=" + this.get(1) + ", M22=" + this.get(3) + ", Dx=" + this.get(4) + ", Dy=" + this.get(5) + ", sizingmethod='auto expand')"
            }, a.offset = function() {
                return [this.e.toFixed(4), this.f.toFixed(4)]
            }, a.split = function() {
                var c = {};
                c.dx = this.e, c.dy = this.f;
                var i = [
                    [this.a, this.c],
                    [this.b, this.d]
                ];
                c.scalex = av.sqrt(f(i[0])), e(i[0]), c.shear = i[0][0] * i[1][0] + i[0][1] * i[1][1], i[1] = [i[1][0] - i[0][0] * c.shear, i[1][1] - i[0][1] * c.shear], c.scaley = av.sqrt(f(i[1])), e(i[1]), c.shear /= c.scaley;
                var h = -i[0][1],
                    d = i[1][1];
                d < 0 ? (c.rotate = a8.deg(av.acos(d)), h < 0 && (c.rotate = 360 - c.rotate)) : c.rotate = a8.deg(av.asin(h)), c.isSimple = !+c.shear.toFixed(9) && (c.scalex.toFixed(9) == c.scaley.toFixed(9) || !c.rotate), c.isSuperSimple = !+c.shear.toFixed(9) && c.scalex.toFixed(9) == c.scaley.toFixed(9) && !c.rotate, c.noRotation = !+c.shear.toFixed(9) && !c.rotate;
                return c
            }, a.toTransformString = function(d) {
                var c = d || this[aD]();
                if (c.isSimple) {
                    c.scalex = +c.scalex.toFixed(4), c.scaley = +c.scaley.toFixed(4), c.rotate = +c.rotate.toFixed(4);
                    return (c.dx || c.dy ? "t" + [c.dx, c.dy] : aJ) + (c.scalex != 1 || c.scaley != 1 ? "s" + [c.scalex, c.scaley, 0, 0] : aJ) + (c.rotate ? "r" + [c.rotate, 0, 0] : aJ)
                }
                return "m" + [this.get(0), this.get(1), this.get(2), this.get(3), this.get(4), this.get(5)]
            }
        }(aL.prototype);
    var aI = navigator.userAgent.match(/Version\/(.*?)\s/) || navigator.userAgent.match(/Chrome\/(\d+)/);
    navigator.vendor == "Apple Computer, Inc." && (aI && aI[1] < 4 || navigator.platform.slice(0, 2) == "iP") || navigator.vendor == "Google Inc." && aI && aI[1] < 8 ? aQ.safari = function() {
        var b = this.rect(-99, -99, this.width + 99, this.height + 99).attr({
            stroke: "none"
        });
        setTimeout(function() {
            b.remove()
        })
    } : aQ.safari = cW;
    var aG = function() {
            this.returnValue = !1
        },
        aE = function() {
            return this.originalEvent.preventDefault()
        },
        aC = function() {
            this.cancelBubble = !0
        },
        aA = function() {
            return this.originalEvent.stopPropagation()
        },
        ay = function() {
            if (aU.doc.addEventListener) {
                return function(h, g, l, k) {
                    var j = aK && az[g] ? az[g] : g,
                        i = function(q) {
                            var p = aU.doc.documentElement.scrollTop || aU.doc.body.scrollTop,
                                o = aU.doc.documentElement.scrollLeft || aU.doc.body.scrollLeft,
                                d = q.clientX + o,
                                c = q.clientY + p;
                            if (aK && az[aV](g)) {
                                for (var b = 0, a = q.targetTouches && q.targetTouches.length; b < a; b++) {
                                    if (q.targetTouches[b].target == h) {
                                        var r = q;
                                        q = q.targetTouches[b], q.originalEvent = r, q.preventDefault = aE, q.stopPropagation = aA;
                                        break
                                    }
                                }
                            }
                            return l.call(k, q, d, c)
                        };
                    h.addEventListener(j, i, !1);
                    return function() {
                        h.removeEventListener(j, i, !1);
                        return !0
                    }
                }
            }
            if (aU.doc.attachEvent) {
                return function(h, g, l, k) {
                    var j = function(d) {
                        d = d || aU.win.event;
                        var c = aU.doc.documentElement.scrollTop || aU.doc.body.scrollTop,
                            o = aU.doc.documentElement.scrollLeft || aU.doc.body.scrollLeft,
                            n = d.clientX + o,
                            m = d.clientY + c;
                        d.preventDefault = d.preventDefault || aG, d.stopPropagation = d.stopPropagation || aC;
                        return l.call(k, d, n, m)
                    };
                    h.attachEvent("on" + g, j);
                    var i = function() {
                        h.detachEvent("on" + g, j);
                        return !0
                    };
                    return i
                }
            }
        }(),
        aw = [],
        au = function(B) {
            var A = B.clientX,
                z = B.clientY,
                y = aU.doc.documentElement.scrollTop || aU.doc.body.scrollTop,
                x = aU.doc.documentElement.scrollLeft || aU.doc.body.scrollLeft,
                w, v = aw.length;
            while (v--) {
                w = aw[v];
                if (aK) {
                    var u = B.touches.length,
                        t;
                    while (u--) {
                        t = B.touches[u];
                        if (t.identifier == w.el._drag.id) {
                            A = t.clientX, z = t.clientY, (B.originalEvent ? B.originalEvent : B).preventDefault();
                            break
                        }
                    }
                } else {
                    B.preventDefault()
                }
                var s = w.el.node,
                    r, q = s.nextSibling,
                    o = s.parentNode,
                    h = s.style.display;
                aU.win.opera && o.removeChild(s), s.style.display = "none", r = w.el.paper.getElementByPoint(A, z), s.style.display = h, aU.win.opera && (q ? o.insertBefore(s, q) : o.appendChild(s)), r && eve("raphael.drag.over." + w.el.id, w.el, r), A += x, z += y, eve("raphael.drag.move." + w.el.id, w.move_scope || w.el, A - w.el._drag.x, z - w.el._drag.y, A, z, B)
            }
        },
        ar = function(a) {
            a8.unmousemove(au).unmouseup(ar);
            var f = aw.length,
                e;
            while (f--) {
                e = aw[f], e.el._drag = {}, eve("raphael.drag.end." + e.el.id, e.end_scope || e.start_scope || e.move_scope || e.el, a)
            }
            aw = []
        },
        ap = a8.el = {};
    for (var an = aB.length; an--;) {
        (function(a) {
            a8[a] = ap[a] = function(e, b) {
                a8.is(e, "function") && (this.events = this.events || [], this.events.push({
                    name: a,
                    f: e,
                    unbind: ay(this.shape || this.node || aU.doc, a, e, b || this)
                }));
                return this
            }, a8["un" + a] = ap["un" + a] = function(b) {
                var f = this.events || [],
                    e = f.length;
                while (e--) {
                    if (f[e].name == a && f[e].f == b) {
                        f[e].unbind(), f.splice(e, 1), !f.length && delete this.events;
                        return this
                    }
                }
                return this
            }
        })(aB[an])
    }
    ap.data = function(a, h) {
        var g = c5[this.id] = c5[this.id] || {};
        if (arguments.length == 1) {
            if (a8.is(a, "object")) {
                for (var f in a) {
                    a[aV](f) && this.data(f, a[f])
                }
                return this
            }
            eve("raphael.data.get." + this.id, this, g[a], a);
            return g[a]
        }
        g[a] = h, eve("raphael.data.set." + this.id, this, h, a);
        return this
    }, ap.removeData = function(b) {
        b == null ? c5[this.id] = {} : c5[this.id] && delete c5[this.id][b];
        return this
    }, ap.hover = function(f, e, h, g) {
        return this.mouseover(f, h).mouseout(e, g || h)
    }, ap.unhover = function(d, c) {
        return this.unmouseover(d).unmouseout(c)
    };
    var am = [];
    ap.drag = function(a, n, m, l, k, j) {
        function h(d) {
            (d.originalEvent || d).preventDefault();
            var c = aU.doc.documentElement.scrollTop || aU.doc.body.scrollTop,
                b = aU.doc.documentElement.scrollLeft || aU.doc.body.scrollLeft;
            this._drag.x = d.clientX + b, this._drag.y = d.clientY + c, this._drag.id = d.identifier, !aw.length && a8.mousemove(au).mouseup(ar), aw.push({
                el: this,
                move_scope: l,
                start_scope: k,
                end_scope: j
            }), n && eve.on("raphael.drag.start." + this.id, n), a && eve.on("raphael.drag.move." + this.id, a), m && eve.on("raphael.drag.end." + this.id, m), eve("raphael.drag.start." + this.id, k || l || this, d.clientX + b, d.clientY + c, d)
        }
        this._drag = {}, am.push({
            el: this,
            start: h
        }), this.mousedown(h);
        return this
    }, ap.onDragOver = function(b) {
        b ? eve.on("raphael.drag.over." + this.id, b) : eve.unbind("raphael.drag.over." + this.id)
    }, ap.undrag = function() {
        var a = am.length;
        while (a--) {
            am[a].el == this && (this.unmousedown(am[a].start), am.splice(a, 1), eve.unbind("raphael.drag.*." + this.id))
        }!am.length && a8.unmousemove(au).unmouseup(ar)
    }, aQ.circle = function(a, h, g) {
        var f = a8._engine.circle(this, a || 0, h || 0, g || 0);
        this.__set__ && this.__set__.push(f);
        return f
    }, aQ.rect = function(a, l, k, j, i) {
        var h = a8._engine.rect(this, a || 0, l || 0, k || 0, j || 0, i || 0);
        this.__set__ && this.__set__.push(h);
        return h
    }, aQ.ellipse = function(a, j, i, h) {
        var g = a8._engine.ellipse(this, a || 0, j || 0, i || 0, h || 0);
        this.__set__ && this.__set__.push(g);
        return g
    }, aQ.path = function(a) {
        a && !a8.is(a, dt) && !a8.is(a[0], dr) && (a += aJ);
        var d = a8._engine.path(a8.format[aO](a8, arguments), this);
        this.__set__ && this.__set__.push(d);
        return d
    }, aQ.image = function(a, l, k, j, i) {
        var h = a8._engine.image(this, a || "about:blank", l || 0, k || 0, j || 0, i || 0);
        this.__set__ && this.__set__.push(h);
        return h
    }, aQ.text = function(a, h, g) {
        var f = a8._engine.text(this, a || 0, h || 0, aF(g));
        this.__set__ && this.__set__.push(f);
        return f
    }, aQ.set = function(a) {
        !a8.is(a, "array") && (a = Array.prototype.splice.call(arguments, 0, arguments.length));
        var d = new cT(a);
        this.__set__ && this.__set__.push(d);
        return d
    }, aQ.setStart = function(b) {
        this.__set__ = b || this.set()
    }, aQ.setFinish = function(d) {
        var c = this.__set__;
        delete this.__set__;
        return c
    }, aQ.setSize = function(a, d) {
        return a8._engine.setSize.call(this, a, d)
    }, aQ.setViewBox = function(a, j, i, h, g) {
        return a8._engine.setViewBox.call(this, a, j, i, h, g)
    }, aQ.top = aQ.bottom = null, aQ.raphael = a8;
    var al = function(r) {
        var q = r.getBoundingClientRect(),
            p = r.ownerDocument,
            o = p.body,
            n = p.documentElement,
            m = n.clientTop || o.clientTop || 0,
            l = n.clientLeft || o.clientLeft || 0,
            k = q.top + (aU.win.pageYOffset || n.scrollTop || o.scrollTop) - m,
            h = q.left + (aU.win.pageXOffset || n.scrollLeft || o.scrollLeft) - l;
        return {
            y: k,
            x: h
        }
    };
    aQ.getElementByPoint = function(j, h) {
        var p = this,
            o = p.canvas,
            n = aU.doc.elementFromPoint(j, h);
        if (aU.win.opera && n.tagName == "svg") {
            var m = al(o),
                l = o.createSVGRect();
            l.x = j - m.x, l.y = h - m.y, l.width = l.height = 1;
            var k = o.getIntersectionList(l, null);
            k.length && (n = k[k.length - 1])
        }
        if (!n) {
            return null
        }
        while (n.parentNode && n != o.parentNode && !n.raphael) {
            n = n.parentNode
        }
        n == p.canvas.parentNode && (n = o), n = n && n.raphael ? p.getById(n.raphaelid) : null;
        return n
    }, aQ.getById = function(d) {
        var c = this.bottom;
        while (c) {
            if (c.id == d) {
                return c
            }
            c = c.next
        }
        return null
    }, aQ.forEach = function(e, d) {
        var f = this.bottom;
        while (f) {
            if (e.call(d, f) === !1) {
                return this
            }
            f = f.next
        }
        return this
    }, aQ.getElementsByPoint = function(e, d) {
        var f = this.set();
        this.forEach(function(a) {
            a.isPointInside(e, d) && f.push(a)
        });
        return f
    }, ap.isPointInside = function(a, f) {
        var e = this.realPath = this.realPath || cL[this.type](this);
        return a8.isPointInsidePath(e, a, f)
    }, ap.getBBox = function(d) {
        if (this.removed) {
            return {}
        }
        var c = this._;
        if (d) {
            if (c.dirty || !c.bboxwt) {
                this.realPath = cL[this.type](this), c.bboxwt = dJ(this.realPath), c.bboxwt.toString = aj, c.dirty = 0
            }
            return c.bboxwt
        }
        if (c.dirty || c.dirtyT || !c.bbox) {
            if (c.dirty || !this.realPath) {
                c.bboxwt = 0, this.realPath = cL[this.type](this)
            }
            c.bbox = dJ(cJ(this.realPath, this.matrix)), c.bbox.toString = aj, c.dirty = c.dirtyT = 0
        }
        return c.bbox
    }, ap.clone = function() {
        if (this.removed) {
            return null
        }
        var b = this.paper[this.type]().attr(this.attr());
        this.__set__ && this.__set__.push(b);
        return b
    }, ap.glow = function(i) {
        if (this.type == "text") {
            return null
        }
        i = i || {};
        var h = {
                width: (i.width || 10) + (+this.attr("stroke-width") || 1),
                fill: i.fill || !1,
                opacity: i.opacity || 0.5,
                offsetx: i.offsetx || 0,
                offsety: i.offsety || 0,
                color: i.color || "#000"
            },
            n = h.width / 2,
            m = this.paper,
            l = m.set(),
            k = this.realPath || cL[this.type](this);
        k = this.matrix ? cJ(k, this.matrix) : k;
        for (var j = 1; j < n + 1; j++) {
            l.push(m.path(k).attr({
                stroke: h.color,
                fill: h.fill ? h.color : "none",
                "stroke-linejoin": "round",
                "stroke-linecap": "round",
                "stroke-width": +(h.width / n * j).toFixed(3),
                opacity: +(h.opacity / n).toFixed(3)
            }))
        }
        return l.insertBefore(this).translate(h.offsetx, h.offsety)
    };
    var ai = {},
        ah = function(r, q, p, o, n, m, l, k, a) {
            return a == null ? dQ(r, q, p, o, n, m, l, k) : a8.findDotsAtSegment(r, q, p, o, n, m, l, k, dP(r, q, p, o, n, m, l, k, a))
        },
        ag = function(a, d) {
            return function(A, z, y) {
                A = dA(A);
                var x, w, v, u, t = "",
                    s = {},
                    r, q = 0;
                for (var c = 0, b = A.length; c < b; c++) {
                    v = A[c];
                    if (v[0] == "M") {
                        x = +v[1], w = +v[2]
                    } else {
                        u = ah(x, w, v[1], v[2], v[3], v[4], v[5], v[6]);
                        if (q + u > z) {
                            if (d && !s.start) {
                                r = ah(x, w, v[1], v[2], v[3], v[4], v[5], v[6], z - q), t += ["C" + r.start.x, r.start.y, r.m.x, r.m.y, r.x, r.y];
                                if (y) {
                                    return t
                                }
                                s.start = t, t = ["M" + r.x, r.y + "C" + r.n.x, r.n.y, r.end.x, r.end.y, v[5], v[6]].join(), q += u, x = +v[5], w = +v[6];
                                continue
                            }
                            if (!a && !d) {
                                r = ah(x, w, v[1], v[2], v[3], v[4], v[5], v[6], z - q);
                                return {
                                    x: r.x,
                                    y: r.y,
                                    alpha: r.alpha
                                }
                            }
                        }
                        q += u, x = +v[5], w = +v[6]
                    }
                    t += v.shift() + v
                }
                s.end = t, r = a ? q : d ? s : a8.findDotsAtSegment(x, w, v[0], v[1], v[2], v[3], v[4], v[5], 1), r.alpha && (r = {
                    x: r.x,
                    y: r.y,
                    alpha: r.alpha
                });
                return r
            }
        },
        af = ag(1),
        ae = ag(),
        ad = ag(0, 1);
    a8.getTotalLength = af, a8.getPointAtLength = ae, a8.getSubpath = function(f, e, h) {
        if (this.getTotalLength(f) - h < 0.000001) {
            return ad(f, e).end
        }
        var g = ad(f, h, 1);
        return e ? ad(g, e).end : g
    }, ap.getTotalLength = function() {
        if (this.type == "path") {
            if (this.node.getTotalLength) {
                return this.node.getTotalLength()
            }
            return af(this.attrs.path)
        }
    }, ap.getPointAtLength = function(b) {
        if (this.type == "path") {
            return ae(this.attrs.path, b)
        }
    }, ap.getSubpath = function(a, d) {
        if (this.type == "path") {
            return a8.getSubpath(this.attrs.path, a, d)
        }
    };
    var ac = a8.easing_formulas = {
        linear: function(b) {
            return b
        },
        "<": function(b) {
            return dz(b, 1.7)
        },
        ">": function(b) {
            return dz(b, 0.48)
        },
        "<>": function(j) {
            var i = 0.48 - j / 1.04,
                p = av.sqrt(0.1734 + i * i),
                o = p - i,
                n = dz(ao(o), 1 / 3) * (o < 0 ? -1 : 1),
                m = -p - i,
                l = dz(ao(m), 1 / 3) * (m < 0 ? -1 : 1),
                k = n + l + 0.5;
            return (1 - k) * 3 * k * k + k * k * k
        },
        backIn: function(d) {
            var c = 1.70158;
            return d * d * ((c + 1) * d - c)
        },
        backOut: function(d) {
            d = d - 1;
            var c = 1.70158;
            return d * d * ((c + 1) * d + c) + 1
        },
        elastic: function(b) {
            if (b == !!b) {
                return b
            }
            return dz(2, -10 * b) * av.sin((b - 0.075) * 2 * dx / 0.3) + 1
        },
        bounce: function(f) {
            var e = 7.5625,
                h = 2.75,
                g;
            f < 1 / h ? g = e * f * f : f < 2 / h ? (f -= 1.5 / h, g = e * f * f + 0.75) : f < 2.5 / h ? (f -= 2.25 / h, g = e * f * f + 0.9375) : (f -= 2.625 / h, g = e * f * f + 0.984375);
            return g
        }
    };
    ac.easeIn = ac["ease-in"] = ac["<"], ac.easeOut = ac["ease-out"] = ac[">"], ac.easeInOut = ac["ease-in-out"] = ac["<>"], ac["back-in"] = ac.backIn, ac["back-out"] = ac.backOut;
    var ab = [],
        aa = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(b) {
            setTimeout(b, 16)
        },
        db = function() {
            var T = +(new Date),
                S = 0;
            for (; S < ab.length; S++) {
                var R = ab[S];
                if (R.el.removed || R.paused) {
                    continue
                }
                var Q = T - R.start,
                    P = R.ms,
                    O = R.easing,
                    N = R.from,
                    M = R.diff,
                    L = R.to,
                    K = R.t,
                    J = R.el,
                    I = {},
                    H, F = {},
                    E;
                R.initstatus ? (Q = (R.initstatus * R.anim.top - R.prev) / (R.percent - R.prev) * P, R.status = R.initstatus, delete R.initstatus, R.stop && ab.splice(S--, 1)) : R.status = (R.prev + (R.percent - R.prev) * (Q / P)) / R.anim.top;
                if (Q < 0) {
                    continue
                }
                if (Q < P) {
                    var D = O(Q / P);
                    for (var C in N) {
                        if (N[aV](C)) {
                            switch (cS[C]) {
                                case dv:
                                    H = +N[C] + D * P * M[C];
                                    break;
                                case "colour":
                                    H = "rgb(" + [c8(da(N[C].r + D * P * M[C].r)), c8(da(N[C].g + D * P * M[C].g)), c8(da(N[C].b + D * P * M[C].b))].join(",") + ")";
                                    break;
                                case "path":
                                    H = [];
                                    for (var B = 0, q = N[C].length; B < q; B++) {
                                        H[B] = [N[C][B][0]];
                                        for (var n = 1, g = N[C][B].length; n < g; n++) {
                                            H[B][n] = +N[C][B][n] + D * P * M[C][B][n]
                                        }
                                        H[B] = H[B].join(aH)
                                    }
                                    H = H.join(aH);
                                    break;
                                case "transform":
                                    if (M[C].real) {
                                        H = [];
                                        for (B = 0, q = N[C].length; B < q; B++) {
                                            H[B] = [N[C][B][0]];
                                            for (n = 1, g = N[C][B].length; n < g; n++) {
                                                H[B][n] = N[C][B][n] + D * P * M[C][B][n]
                                            }
                                        }
                                    } else {
                                        var a = function(b) {
                                            return +N[C][b] + D * P * M[C][b]
                                        };
                                        H = [
                                            ["m", a(0), a(1), a(2), a(3), a(4), a(5)]
                                        ]
                                    }
                                    break;
                                case "csv":
                                    if (C == "clip-rect") {
                                        H = [], B = 4;
                                        while (B--) {
                                            H[B] = +N[C][B] + D * P * M[C][B]
                                        }
                                    }
                                    break;
                                default:
                                    var G = [][aN](N[C]);
                                    H = [], B = J.paper.customAttributes[C].length;
                                    while (B--) {
                                        H[B] = +G[B] + D * P * M[C][B]
                                    }
                            }
                            I[C] = H
                        }
                    }
                    J.attr(I),
                        function(e, d, f) {
                            setTimeout(function() {
                                eve("raphael.anim.frame." + e, d, f)
                            })
                        }(J.id, J, R.anim)
                } else {
                    (function(e, h, f) {
                        setTimeout(function() {
                            eve("raphael.anim.frame." + h.id, h, f), eve("raphael.anim.finish." + h.id, h, f), a8.is(e, "function") && e.call(h)
                        })
                    })(R.callback, J, R.anim), J.attr(L), ab.splice(S--, 1);
                    if (R.repeat > 1 && !R.next) {
                        for (E in L) {
                            L[aV](E) && (F[E] = R.totalOrigin[E])
                        }
                        R.el.attr(F), c0(R.anim, R.el, R.anim.percents[0], null, R.totalOrigin, R.repeat - 1)
                    }
                    R.next && !R.stop && c0(R.anim, R.el, R.next, null, R.totalOrigin, R.repeat)
                }
            }
            a8.svg && J && J.paper && J.paper.safari(), ab.length && aa(db)
        },
        c8 = function(b) {
            return b > 255 ? 255 : b < 0 ? 0 : b
        };
    ap.animateWith = function(x, w, v, u, t, s) {
        var r = this;
        if (r.removed) {
            s && s.call(r);
            return r
        }
        var q = v instanceof c3 ? v : a8.animation(v, u, t, s),
            p, o;
        c0(q, r, q.percents[0], null, r.attr());
        for (var n = 0, a = ab.length; n < a; n++) {
            if (ab[n].anim == w && ab[n].el == x) {
                ab[a - 1].start = ab[n].start;
                break
            }
        }
        return r
    }, ap.onAnimation = function(b) {
        b ? eve.on("raphael.anim.frame." + this.id, b) : eve.unbind("raphael.anim.frame." + this.id);
        return this
    }, c3.prototype.delay = function(d) {
        var c = new c3(this.anim, this.ms);
        c.times = this.times, c.del = +d || 0;
        return c
    }, c3.prototype.repeat = function(d) {
        var c = new c3(this.anim, this.ms);
        c.del = this.del, c.times = av.floor(at(d, 0)) || 1;
        return c
    }, a8.animation = function(a, n, m, l) {
        if (a instanceof c3) {
            return a
        }
        if (a8.is(m, "function") || !m) {
            l = l || m || null, m = null
        }
        a = Object(a), n = +n || 0;
        var k = {},
            j, g;
        for (g in a) {
            a[aV](g) && c4(g) != g && c4(g) + "%" != g && (j = !0, k[g] = a[g])
        }
        if (!j) {
            return new c3(a, n)
        }
        m && (k.easing = m), l && (k.callback = l);
        return new c3({
            100: k
        }, n)
    }, ap.animate = function(a, l, k, j) {
        var i = this;
        if (i.removed) {
            j && j.call(i);
            return i
        }
        var h = a instanceof c3 ? a : a8.animation(a, l, k, j);
        c0(h, i, h.percents[0], null, i.attr());
        return i
    }, ap.setTime = function(d, c) {
        d && c != null && this.status(d, aq(c, d.ms) / d.ms);
        return this
    }, ap.status = function(h, g) {
        var l = [],
            k = 0,
            j, i;
        if (g != null) {
            c0(h, this, -1, aq(g, 1));
            return this
        }
        j = ab.length;
        for (; k < j; k++) {
            i = ab[k];
            if (i.el.id == this.id && (!h || i.anim == h)) {
                if (h) {
                    return i.status
                }
                l.push({
                    anim: i.anim,
                    status: i.status
                })
            }
        }
        if (h) {
            return 0
        }
        return l
    }, ap.pause = function(d) {
        for (var c = 0; c < ab.length; c++) {
            ab[c].el.id == this.id && (!d || ab[c].anim == d) && eve("raphael.anim.pause." + this.id, this, ab[c].anim) !== !1 && (ab[c].paused = !0)
        }
        return this
    }, ap.resume = function(e) {
        for (var d = 0; d < ab.length; d++) {
            if (ab[d].el.id == this.id && (!e || ab[d].anim == e)) {
                var f = ab[d];
                eve("raphael.anim.resume." + this.id, this, f.anim) !== !1 && (delete f.paused, this.status(f.anim, f.status))
            }
        }
        return this
    }, ap.stop = function(d) {
        for (var c = 0; c < ab.length; c++) {
            ab[c].el.id == this.id && (!d || ab[c].anim == d) && eve("raphael.anim.stop." + this.id, this, ab[c].anim) !== !1 && ab.splice(c--, 1)
        }
        return this
    }, eve.on("raphael.remove", cX), eve.on("raphael.clear", cX), ap.toString = function() {
        return "RaphaÃ«lâ€™s object"
    };
    var cT = function(e) {
            this.items = [], this.length = 0, this.type = "set";
            if (e) {
                for (var d = 0, f = e.length; d < f; d++) {
                    e[d] && (e[d].constructor == ap.constructor || e[d].constructor == cT) && (this[this.items.length] = this.items[this.items.length] = e[d], this.length++)
                }
            }
        },
        cQ = cT.prototype;
    cQ.push = function() {
        var f, e;
        for (var h = 0, g = arguments.length; h < g; h++) {
            f = arguments[h], f && (f.constructor == ap.constructor || f.constructor == cT) && (e = this.items.length, this[e] = this.items[e] = f, this.length++)
        }
        return this
    }, cQ.pop = function() {
        this.length && delete this[this.length--];
        return this.items.pop()
    }, cQ.forEach = function(f, e) {
        for (var h = 0, g = this.items.length; h < g; h++) {
            if (f.call(e, this.items[h], h) === !1) {
                return this
            }
        }
        return this
    };
    for (var cN in ap) {
        ap[aV](cN) && (cQ[cN] = function(b) {
            return function() {
                var a = arguments;
                return this.forEach(function(d) {
                    d[b][aO](d, a)
                })
            }
        }(cN))
    }
    cQ.attr = function(a, l) {
            if (a && a8.is(a, dr) && a8.is(a[0], "object")) {
                for (var k = 0, j = a.length; k < j; k++) {
                    this.items[k].attr(a[k])
                }
            } else {
                for (var i = 0, h = this.items.length; i < h; i++) {
                    this.items[i].attr(a, l)
                }
            }
            return this
        }, cQ.clear = function() {
            while (this.length) {
                this.pop()
            }
        }, cQ.splice = function(j, i, p) {
            j = j < 0 ? at(this.length + j, 0) : j, i = at(0, aq(this.length - j, i));
            var o = [],
                n = [],
                m = [],
                l;
            for (l = 2; l < arguments.length; l++) {
                m.push(arguments[l])
            }
            for (l = 0; l < i; l++) {
                n.push(this[j + l])
            }
            for (; l < this.length - j; l++) {
                o.push(this[j + l])
            }
            var k = m.length;
            for (l = 0; l < k + o.length; l++) {
                this.items[j + l] = this[j + l] = l < k ? m[l] : o[l - k]
            }
            l = this.items.length = this.length -= i - k;
            while (this[l]) {
                delete this[l++]
            }
            return new cT(n)
        }, cQ.exclude = function(e) {
            for (var d = 0, f = this.length; d < f; d++) {
                if (this[d] == e) {
                    this.splice(d, 1);
                    return !0
                }
            }
        }, cQ.animate = function(t, s, r, q) {
            (a8.is(r, "function") || !r) && (q = r || null);
            var p = this.items.length,
                o = p,
                n, m = this,
                l;
            if (!p) {
                return this
            }
            q && (l = function() {
                !--p && q.call(m)
            }), r = a8.is(r, dt) ? r : l;
            var a = a8.animation(t, s, r, l);
            n = this.items[--o].animate(a);
            while (o--) {
                this.items[o] && !this.items[o].removed && this.items[o].animateWith(n, a, a)
            }
            return this
        }, cQ.insertAfter = function(d) {
            var c = this.items.length;
            while (c--) {
                this.items[c].insertAfter(d)
            }
            return this
        }, cQ.getBBox = function() {
            var h = [],
                g = [],
                l = [],
                k = [];
            for (var j = this.items.length; j--;) {
                if (!this.items[j].removed) {
                    var i = this.items[j].getBBox();
                    h.push(i.x), g.push(i.y), l.push(i.x + i.width), k.push(i.y + i.height)
                }
            }
            h = aq[aO](0, h), g = aq[aO](0, g), l = at[aO](0, l), k = at[aO](0, k);
            return {
                x: h,
                y: g,
                x2: l,
                y2: k,
                width: l - h,
                height: k - g
            }
        }, cQ.clone = function(e) {
            e = new cT;
            for (var d = 0, f = this.items.length; d < f; d++) {
                e.push(this.items[d].clone())
            }
            return e
        }, cQ.toString = function() {
            return "RaphaÃ«lâ€˜s set"
        }, a8.registerFont = function(i) {
            if (!i.face) {
                return i
            }
            this.fonts = this.fonts || {};
            var g = {
                    w: i.w,
                    face: {},
                    glyphs: {}
                },
                n = i.face["font-family"];
            for (var m in i.face) {
                i.face[aV](m) && (g.face[m] = i.face[m])
            }
            this.fonts[n] ? this.fonts[n].push(g) : this.fonts[n] = [g];
            if (!i.svg) {
                g.face["units-per-em"] = c1(i.face["units-per-em"], 10);
                for (var l in i.glyphs) {
                    if (i.glyphs[aV](l)) {
                        var k = i.glyphs[l];
                        g.glyphs[l] = {
                            w: k.w,
                            k: {},
                            d: k.d && "M" + k.d.replace(/[mlcxtrv]/g, function(b) {
                                return {
                                    l: "L",
                                    c: "C",
                                    x: "z",
                                    t: "m",
                                    r: "l",
                                    v: "c"
                                } [b] || "M"
                            }) + "z"
                        };
                        if (k.k) {
                            for (var j in k.k) {
                                k[aV](j) && (g.glyphs[l].k[j] = k.k[j])
                            }
                        }
                    }
                }
            }
            return i
        }, aQ.getFont = function(t, s, r, q) {
            q = q || "normal", r = r || "normal", s = +s || {
                normal: 400,
                bold: 700,
                lighter: 300,
                bolder: 800
            } [s] || 400;
            if (!!a8.fonts) {
                var p = a8.fonts[t];
                if (!p) {
                    var o = new RegExp("(^|\\s)" + t.replace(/[^\w\d\s+!~.:_-]/g, aJ) + "(\\s|$)", "i");
                    for (var n in a8.fonts) {
                        if (a8.fonts[aV](n) && o.test(n)) {
                            p = a8.fonts[n];
                            break
                        }
                    }
                }
                var m;
                if (p) {
                    for (var g = 0, a = p.length; g < a; g++) {
                        m = p[g];
                        if (m.face["font-weight"] == s && (m.face["font-style"] == r || !m.face["font-style"]) && m.face["font-stretch"] == q) {
                            break
                        }
                    }
                }
                return m
            }
        }, aQ.print = function(P, O, N, M, L, K, J) {
            K = K || "middle", J = at(aq(J || 0, 1), -1);
            var I = aF(N)[aD](aJ),
                H = 0,
                G = 0,
                F = aJ,
                E;
            a8.is(M, N) && (M = this.getFont(M));
            if (M) {
                E = (L || 16) / M.face["units-per-em"];
                var D = M.face.bbox[aD](a3),
                    y = +D[0],
                    s = D[3] - D[1],
                    r = 0,
                    p = +D[1] + (K == "baseline" ? s + +M.face.descent : s / 2);
                for (var c = 0, a = I.length; c < a; c++) {
                    if (I[c] == "\n") {
                        H = 0, x = 0, G = 0, r += s
                    } else {
                        var C = G && M.glyphs[I[c - 1]] || {},
                            x = M.glyphs[I[c]];
                        H += G ? (C.w || M.w) + (C.k && C.k[I[c]] || 0) + M.w * J : 0, G = 1
                    }
                    x && x.d && (F += a8.transformPath(x.d, ["t", H * E, r * E, "s", E, E, y, p, "t", (P - y) / E, (O - p) / E]))
                }
            }
            return this.path(F).attr({
                fill: "#000",
                stroke: "none"
            })
        }, aQ.add = function(a) {
            if (a8.is(a, "array")) {
                var j = this.set(),
                    i = 0,
                    g = a.length,
                    d;
                for (; i < g; i++) {
                    d = a[i] || {}, a1[aV](d.type) && j.push(this[d.type]().attr(d))
                }
            }
            return j
        }, a8.format = function(a, f) {
            var e = a8.is(f, dr) ? [0][aN](f) : arguments;
            a && a8.is(a, dt) && e.length - 1 && (a = a.replace(a0, function(d, c) {
                return e[++c] == null ? aJ : e[c]
            }));
            return a || aJ
        }, a8.fullfill = function() {
            var e = /\{([^\}]+)\}/g,
                d = /(?:(?:^|\.)(.+?)(?=\[|\.|$|\()|\[('|")(.+?)\2\])(\(\))?/g,
                f = function(b, i, h) {
                    var g = h;
                    i.replace(d, function(k, j, n, m, l) {
                        j = j || m, g && (j in g && (g = g[j]), typeof g == "function" && l && (g = g()))
                    }), g = (g == null || g == h ? b : g) + "";
                    return g
                };
            return function(a, c) {
                return String(a).replace(e, function(h, g) {
                    return f(h, g, c)
                })
            }
        }(), a8.ninja = function() {
            aS.was ? aU.win.Raphael = aS.is : delete Raphael;
            return a8
        }, a8.st = cQ,
        function(a, h, g) {
            function f() {
                /in/.test(a.readyState) ? setTimeout(f, 9) : a8.eve("raphael.DOMload")
            }
            a.readyState == null && a.addEventListener && (a.addEventListener(h, g = function() {
                a.removeEventListener(h, g, !1), a.readyState = "complete"
            }, !1), a.readyState = "loading"), f()
        }(document, "DOMContentLoaded"), aS.was ? aU.win.Raphael = a8 : Raphael = a8, eve.on("raphael.DOMload", function() {
            a6 = !0
        })
}(), window.Raphael.svg && function(af) {
    var ae = "hasOwnProperty",
        ad = String,
        ac = parseFloat,
        ab = parseInt,
        aa = Math,
        Z = aa.max,
        Y = aa.abs,
        X = aa.pow,
        W = /[, ]+/,
        V = af.eve,
        U = "",
        T = " ",
        S = "http://www.w3.org/1999/xlink",
        R = {
            block: "M5,0 0,2.5 5,5z",
            classic: "M5,0 0,2.5 5,5 3.5,3 3.5,2z",
            diamond: "M2.5,0 5,2.5 2.5,5 0,2.5z",
            open: "M6,1 1,3.5 6,6",
            oval: "M2.5,0A2.5,2.5,0,0,1,2.5,5 2.5,2.5,0,0,1,2.5,0z"
        },
        Q = {};
    af.toString = function() {
        return "Your browser supports SVG.\nYou are running RaphaÃ«l " + this.version

    };
    var O = function(c, b) {
            if (b) {
                typeof c == "string" && (c = O(c));
                for (var a in b) {
                    b[ae](a) && (a.substring(0, 6) == "xlink:" ? c.setAttributeNS(S, a.substring(6), ad(b[a])) : c.setAttribute(a, ad(b[a])))
                }
            } else {
                c = af._g.doc.createElementNS("http://www.w3.org/2000/svg", c), c.style && (c.style.webkitTapHighlightColor = "rgba(0,0,0,0)")
            }
            return c
        },
        M = function(z, l) {
            var i = "linear",
                h = z.id + l,
                g = 0.5,
                f = 0.5,
                d = z.node,
                c = z.paper,
                a = d.style,
                ai = af._g.doc.getElementById(h);
            if (!ai) {
                l = ad(l).replace(af._radial_gradient, function(k, j, n) {
                    i = "radial";
                    if (j && n) {
                        g = ac(j), f = ac(n);
                        var m = (f > 0.5) * 2 - 1;
                        X(g - 0.5, 2) + X(f - 0.5, 2) > 0.25 && (f = aa.sqrt(0.25 - X(g - 0.5, 2)) * m + 0.5) && f != 0.5 && (f = f.toFixed(5) - 0.00001 * m)
                    }
                    return U
                }), l = l.split(/\s*\-\s*/);
                if (i == "linear") {
                    var ah = l.shift();
                    ah = -ac(ah);
                    if (isNaN(ah)) {
                        return null
                    }
                    var ag = [0, 0, aa.cos(af.rad(ah)), aa.sin(af.rad(ah))],
                        C = 1 / (Z(Y(ag[2]), Y(ag[3])) || 1);
                    ag[2] *= C, ag[3] *= C, ag[2] < 0 && (ag[0] = -ag[2], ag[2] = 0), ag[3] < 0 && (ag[1] = -ag[3], ag[3] = 0)
                }
                var B = af._parseDots(l);
                if (!B) {
                    return null
                }
                h = h.replace(/[\(\)\s,\xb0#]/g, "_"), z.gradient && h != z.gradient.id && (c.defs.removeChild(z.gradient), delete z.gradient);
                if (!z.gradient) {
                    ai = O(i + "Gradient", {
                        id: h
                    }), z.gradient = ai, O(ai, i == "radial" ? {
                        fx: g,
                        fy: f
                    } : {
                        x1: ag[0],
                        y1: ag[1],
                        x2: ag[2],
                        y2: ag[3],
                        gradientTransform: z.matrix.invert()
                    }), c.defs.appendChild(ai);
                    for (var A = 0, q = B.length; A < q; A++) {
                        ai.appendChild(O("stop", {
                            offset: B[A].offset ? B[A].offset : A ? "100%" : "0%",
                            "stop-color": B[A].color || "#fff"
                        }))
                    }
                }
            }
            O(d, {
                fill: "url(#" + h + ")",
                opacity: 1,
                "fill-opacity": 1
            }), a.fill = U, a.opacity = 1, a.fillOpacity = 1;
            return 1
        },
        K = function(d) {
            var c = d.getBBox(1);
            O(d.pattern, {
                patternTransform: d.matrix.invert() + " translate(" + c.x + "," + c.y + ")"
            })
        },
        J = function(ay, ax, aw) {
            if (ay.type == "path") {
                var av = ad(ax).toLowerCase().split("-"),
                    au = ay.paper,
                    at = aw ? "end" : "start",
                    ar = ay.node,
                    aq = ay.attrs,
                    ap = aq["stroke-width"],
                    ao = av.length,
                    al = "classic",
                    aj, ah, ag, p, l, c = 3,
                    b = 3,
                    a = 5;
                while (ao--) {
                    switch (av[ao]) {
                        case "block":
                        case "classic":
                        case "oval":
                        case "diamond":
                        case "open":
                        case "none":
                            al = av[ao];
                            break;
                        case "wide":
                            b = 5;
                            break;
                        case "narrow":
                            b = 2;
                            break;
                        case "long":
                            c = 5;
                            break;
                        case "short":
                            c = 2
                    }
                }
                al == "open" ? (c += 2, b += 2, a += 2, ag = 1, p = aw ? 4 : 1, l = {
                    fill: "none",
                    stroke: aq.stroke
                }) : (p = ag = c / 2, l = {
                    fill: aq.stroke,
                    stroke: "none"
                }), ay._.arrows ? aw ? (ay._.arrows.endPath && Q[ay._.arrows.endPath]--, ay._.arrows.endMarker && Q[ay._.arrows.endMarker]--) : (ay._.arrows.startPath && Q[ay._.arrows.startPath]--, ay._.arrows.startMarker && Q[ay._.arrows.startMarker]--) : ay._.arrows = {};
                if (al != "none") {
                    var an = "raphael-marker-" + al,
                        am = "raphael-marker-" + at + al + c + b;
                    af._g.doc.getElementById(an) ? Q[an]++ : (au.defs.appendChild(O(O("path"), {
                        "stroke-linecap": "round",
                        d: R[al],
                        id: an
                    })), Q[an] = 1);
                    var ak = af._g.doc.getElementById(am),
                        ai;
                    ak ? (Q[am]++, ai = ak.getElementsByTagName("use")[0]) : (ak = O(O("marker"), {
                        id: am,
                        markerHeight: b,
                        markerWidth: c,
                        orient: "auto",
                        refX: p,
                        refY: b / 2
                    }), ai = O(O("use"), {
                        "xlink:href": "#" + an,
                        transform: (aw ? "rotate(180 " + c / 2 + " " + b / 2 + ") " : U) + "scale(" + c / a + "," + b / a + ")",
                        "stroke-width": (1 / ((c / a + b / a) / 2)).toFixed(4)
                    }), ak.appendChild(ai), au.defs.appendChild(ak), Q[am] = 1), O(ai, l);
                    var q = ag * (al != "diamond" && al != "oval");
                    aw ? (aj = ay._.arrows.startdx * ap || 0, ah = af.getTotalLength(aq.path) - q * ap) : (aj = q * ap, ah = af.getTotalLength(aq.path) - (ay._.arrows.enddx * ap || 0)), l = {}, l["marker-" + at] = "url(#" + am + ")";
                    if (ah || aj) {
                        l.d = Raphael.getSubpath(aq.path, aj, ah)
                    }
                    O(ar, l), ay._.arrows[at + "Path"] = an, ay._.arrows[at + "Marker"] = am, ay._.arrows[at + "dx"] = q, ay._.arrows[at + "Type"] = al, ay._.arrows[at + "String"] = ax
                } else {
                    aw ? (aj = ay._.arrows.startdx * ap || 0, ah = af.getTotalLength(aq.path) - aj) : (aj = 0, ah = af.getTotalLength(aq.path) - (ay._.arrows.enddx * ap || 0)), ay._.arrows[at + "Path"] && O(ar, {
                        d: Raphael.getSubpath(aq.path, aj, ah)
                    }), delete ay._.arrows[at + "Path"], delete ay._.arrows[at + "Marker"], delete ay._.arrows[at + "dx"], delete ay._.arrows[at + "Type"], delete ay._.arrows[at + "String"]
                }
                for (l in Q) {
                    if (Q[ae](l) && !Q[l]) {
                        var o = af._g.doc.getElementById(l);
                        o && o.parentNode.removeChild(o)
                    }
                }
            }
        },
        I = {
            "": [0],
            none: [0],
            "-": [3, 1],
            ".": [1, 1],
            "-.": [3, 1, 1, 1],
            "-..": [3, 1, 1, 1, 1, 1],
            ". ": [1, 3],
            "- ": [4, 3],
            "--": [8, 3],
            "- .": [4, 3, 1, 3],
            "--.": [8, 3, 1, 3],
            "--..": [8, 3, 1, 3, 1, 3]
        },
        H = function(i, c, n) {
            c = I[ad(c).toLowerCase()];
            if (c) {
                var m = i.attrs["stroke-width"] || "1",
                    l = {
                        round: m,
                        square: m,
                        butt: 0
                    } [i.attrs["stroke-linecap"] || n["stroke-linecap"]] || 0,
                    k = [],
                    j = c.length;
                while (j--) {
                    k[j] = c[j] * m + (j % 2 ? 1 : -1) * l
                }
                O(i.node, {
                    "stroke-dasharray": k.join(",")
                })
            }
        },
        G = function(ak, aj) {
            var ai = ak.node,
                ah = ak.attrs,
                ag = ai.style.visibility;
            ai.style.visibility = "hidden";
            for (var y in aj) {
                if (aj[ae](y)) {
                    if (!af._availableAttrs[ae](y)) {
                        continue
                    }
                    var v = aj[y];
                    ah[y] = v;
                    switch (y) {
                        case "blur":
                            ak.blur(v);
                            break;
                        case "href":
                        case "title":
                        case "target":
                            var n = ai.parentNode;
                            if (n.tagName.toLowerCase() != "a") {
                                var h = O("a");
                                n.insertBefore(h, ai), h.appendChild(ai), n = h
                            }
                            y == "target" ? n.setAttributeNS(S, "show", v == "blank" ? "new" : v) : n.setAttributeNS(S, y, v);
                            break;
                        case "cursor":
                            ai.style.cursor = v;
                            break;
                        case "transform":
                            ak.transform(v);
                            break;
                        case "arrow-start":
                            J(ak, v);
                            break;
                        case "arrow-end":
                            J(ak, v, 1);
                            break;
                        case "clip-rect":
                            var e = ad(v).split(W);
                            if (e.length == 4) {
                                ak.clip && ak.clip.parentNode.parentNode.removeChild(ak.clip.parentNode);
                                var a = O("clipPath"),
                                    t = O("rect");
                                a.id = af.createUUID(), O(t, {
                                    x: e[0],
                                    y: e[1],
                                    width: e[2],
                                    height: e[3]
                                }), a.appendChild(t), ak.paper.defs.appendChild(a), O(ai, {
                                    "clip-path": "url(#" + a.id + ")"
                                }), ak.clip = t
                            }
                            if (!v) {
                                var s = ai.getAttribute("clip-path");
                                if (s) {
                                    var r = af._g.doc.getElementById(s.replace(/(^url\(#|\)$)/g, U));
                                    r && r.parentNode.removeChild(r), O(ai, {
                                        "clip-path": U
                                    }), delete ak.clip
                                }
                            }
                            break;
                        case "path":
                            ak.type == "path" && (O(ai, {
                                d: v ? ah.path = af._pathToAbsolute(v) : "M0,0"
                            }), ak._.dirty = 1, ak._.arrows && ("startString" in ak._.arrows && J(ak, ak._.arrows.startString), "endString" in ak._.arrows && J(ak, ak._.arrows.endString, 1)));
                            break;
                        case "width":
                            ai.setAttribute(y, v), ak._.dirty = 1;
                            if (ah.fx) {
                                y = "x", v = ah.x
                            } else {
                                break
                            }
                        case "x":
                            ah.fx && (v = -ah.x - (ah.width || 0));
                        case "rx":
                            if (y == "rx" && ak.type == "rect") {
                                break
                            }
                        case "cx":
                            ai.setAttribute(y, v), ak.pattern && K(ak), ak._.dirty = 1;
                            break;
                        case "height":
                            ai.setAttribute(y, v), ak._.dirty = 1;
                            if (ah.fy) {
                                y = "y", v = ah.y
                            } else {
                                break
                            }
                        case "y":
                            ah.fy && (v = -ah.y - (ah.height || 0));
                        case "ry":
                            if (y == "ry" && ak.type == "rect") {
                                break
                            }
                        case "cy":
                            ai.setAttribute(y, v), ak.pattern && K(ak), ak._.dirty = 1;
                            break;
                        case "r":
                            ak.type == "rect" ? O(ai, {
                                rx: v,
                                ry: v
                            }) : ai.setAttribute(y, v), ak._.dirty = 1;
                            break;
                        case "src":
                            ak.type == "image" && ai.setAttributeNS(S, "href", v);
                            break;
                        case "stroke-width":
                            if (ak._.sx != 1 || ak._.sy != 1) {
                                v /= Z(Y(ak._.sx), Y(ak._.sy)) || 1
                            }
                            ak.paper._vbSize && (v *= ak.paper._vbSize), ai.setAttribute(y, v), ah["stroke-dasharray"] && H(ak, ah["stroke-dasharray"], aj), ak._.arrows && ("startString" in ak._.arrows && J(ak, ak._.arrows.startString), "endString" in ak._.arrows && J(ak, ak._.arrows.endString, 1));
                            break;
                        case "stroke-dasharray":
                            H(ak, v, aj);
                            break;
                        case "fill":
                            var q = ad(v).match(af._ISURL);
                            if (q) {
                                a = O("pattern");
                                var l = O("image");
                                a.id = af.createUUID(), O(a, {
                                        x: 0,
                                        y: 0,
                                        patternUnits: "userSpaceOnUse",
                                        height: 1,
                                        width: 1
                                    }), O(l, {
                                        x: 0,
                                        y: 0,
                                        "xlink:href": q[1]
                                    }), a.appendChild(l),
                                    function(d) {
                                        af._preload(q[1], function() {
                                            var f = this.offsetWidth,
                                                i = this.offsetHeight;
                                            O(d, {
                                                width: f,
                                                height: i
                                            }), O(l, {
                                                width: f,
                                                height: i
                                            }), ak.paper.safari()
                                        })
                                    }(a), ak.paper.defs.appendChild(a), O(ai, {
                                        fill: "url(#" + a.id + ")"
                                    }), ak.pattern = a, ak.pattern && K(ak);
                                break
                            }
                            var j = af.getRGB(v);
                            if (!j.error) {
                                delete aj.gradient, delete ah.gradient, !af.is(ah.opacity, "undefined") && af.is(aj.opacity, "undefined") && O(ai, {
                                    opacity: ah.opacity
                                }), !af.is(ah["fill-opacity"], "undefined") && af.is(aj["fill-opacity"], "undefined") && O(ai, {
                                    "fill-opacity": ah["fill-opacity"]
                                })
                            } else {
                                if ((ak.type == "circle" || ak.type == "ellipse" || ad(v).charAt() != "r") && M(ak, v)) {
                                    if ("opacity" in ah || "fill-opacity" in ah) {
                                        var g = af._g.doc.getElementById(ai.getAttribute("fill").replace(/^url\(#|\)$/g, U));
                                        if (g) {
                                            var c = g.getElementsByTagName("stop");
                                            O(c[c.length - 1], {
                                                "stop-opacity": ("opacity" in ah ? ah.opacity : 1) * ("fill-opacity" in ah ? ah["fill-opacity"] : 1)
                                            })
                                        }
                                    }
                                    ah.gradient = v, ah.fill = "none";
                                    break
                                }
                            }
                            j[ae]("opacity") && O(ai, {
                                "fill-opacity": j.opacity > 1 ? j.opacity / 100 : j.opacity
                            });
                        case "stroke":
                            j = af.getRGB(v), ai.setAttribute(y, j.hex), y == "stroke" && j[ae]("opacity") && O(ai, {
                                "stroke-opacity": j.opacity > 1 ? j.opacity / 100 : j.opacity
                            }), y == "stroke" && ak._.arrows && ("startString" in ak._.arrows && J(ak, ak._.arrows.startString), "endString" in ak._.arrows && J(ak, ak._.arrows.endString, 1));
                            break;
                        case "gradient":
                            (ak.type == "circle" || ak.type == "ellipse" || ad(v).charAt() != "r") && M(ak, v);
                            break;
                        case "opacity":
                            ah.gradient && !ah[ae]("stroke-opacity") && O(ai, {
                                "stroke-opacity": v > 1 ? v / 100 : v
                            });
                        case "fill-opacity":
                            if (ah.gradient) {
                                g = af._g.doc.getElementById(ai.getAttribute("fill").replace(/^url\(#|\)$/g, U)), g && (c = g.getElementsByTagName("stop"), O(c[c.length - 1], {
                                    "stop-opacity": v
                                }));
                                break
                            }
                        default:
                            y == "font-size" && (v = ab(v, 10) + "px");
                            var b = y.replace(/(\-.)/g, function(d) {
                                return d.substring(1).toUpperCase()
                            });
                            ai.style[b] = v, ak._.dirty = 1, ai.setAttribute(y, v)
                    }
                }
            }
            E(ak, aj), ai.style.visibility = ag
        },
        F = 1.2,
        E = function(x, w) {
            if (x.type == "text" && !!(w[ae]("text") || w[ae]("font") || w[ae]("font-size") || w[ae]("x") || w[ae]("y"))) {
                var v = x.attrs,
                    u = x.node,
                    t = u.firstChild ? ab(af._g.doc.defaultView.getComputedStyle(u.firstChild, U).getPropertyValue("font-size"), 10) : 10;
                if (w[ae]("text")) {
                    v.text = w.text;
                    while (u.firstChild) {
                        u.removeChild(u.firstChild)
                    }
                    var s = ad(w.text).split("\n"),
                        q = [],
                        l;
                    for (var e = 0, c = s.length; e < c; e++) {
                        l = O("tspan"), e && O(l, {
                            dy: t * F,
                            x: v.x
                        }), l.appendChild(af._g.doc.createTextNode(s[e])), u.appendChild(l), q[e] = l
                    }
                } else {
                    q = u.getElementsByTagName("tspan");
                    for (e = 0, c = q.length; e < c; e++) {
                        e ? O(q[e], {
                            dy: t * F,
                            x: v.x
                        }) : O(q[0], {
                            dy: 0
                        })
                    }
                }
                O(u, {
                    x: v.x,
                    y: v.y
                }), x._.dirty = 1;
                var b = x._getBBox(),
                    a = v.y - (b.y + b.height / 2);
                a && af.is(a, "finite") && O(q[0], {
                    dy: a
                })
            }
        },
        D = function(a, h) {
            var g = 0,
                f = 0;
            this[0] = this.node = a, a.raphael = !0, this.id = af._oid++, a.raphaelid = this.id, this.matrix = af.matrix(), this.realPath = null, this.paper = h, this.attrs = this.attrs || {}, this._ = {
                transform: [],
                sx: 1,
                sy: 1,
                deg: 0,
                dx: 0,
                dy: 0,
                dirty: 1
            }, !h.bottom && (h.bottom = this), this.prev = h.top, h.top && (h.top.next = this), h.top = this, this.next = null
        },
        P = af.el;
    D.prototype = P, P.constructor = D, af._engine.path = function(f, e) {
        var h = O("path");
        e.canvas && e.canvas.appendChild(h);
        var g = new D(h, e);
        g.type = "path", G(g, {
            fill: "none",
            stroke: "#000",
            path: f
        });
        return g
    }, P.rotate = function(d, c, h) {
        if (this.removed) {
            return this
        }
        d = ad(d).split(W), d.length - 1 && (c = ac(d[1]), h = ac(d[2])), d = ac(d[0]), h == null && (c = h);
        if (c == null || h == null) {
            var g = this.getBBox(1);
            c = g.x + g.width / 2, h = g.y + g.height / 2
        }
        this.transform(this._.transform.concat([
            ["r", d, c, h]
        ]));
        return this
    }, P.scale = function(d, c, j, i) {
        if (this.removed) {
            return this
        }
        d = ad(d).split(W), d.length - 1 && (c = ac(d[1]), j = ac(d[2]), i = ac(d[3])), d = ac(d[0]), c == null && (c = d), i == null && (j = i);
        if (j == null || i == null) {
            var h = this.getBBox(1)
        }
        j = j == null ? h.x + h.width / 2 : j, i = i == null ? h.y + h.height / 2 : i, this.transform(this._.transform.concat([
            ["s", d, c, j, i]
        ]));
        return this
    }, P.translate = function(d, c) {
        if (this.removed) {
            return this
        }
        d = ad(d).split(W), d.length - 1 && (c = ac(d[1])), d = ac(d[0]) || 0, c = +c || 0, this.transform(this._.transform.concat([
            ["t", d, c]
        ]));
        return this
    }, P.transform = function(f) {
        var b = this._;
        if (f == null) {
            return b.transform
        }
        af._extractTransform(this, f), this.clip && O(this.clip, {
            transform: this.matrix.invert()
        }), this.pattern && K(this), this.node && O(this.node, {
            transform: this.matrix
        });
        if (b.sx != 1 || b.sy != 1) {
            var a = this.attrs[ae]("stroke-width") ? this.attrs["stroke-width"] : 1;
            this.attr({
                "stroke-width": a
            })
        }
        return this
    }, P.hide = function() {
        !this.removed && this.paper.safari(this.node.style.display = "none");
        return this
    }, P.show = function() {
        !this.removed && this.paper.safari(this.node.style.display = "");
        return this
    }, P.remove = function() {
        if (!this.removed && !!this.node.parentNode) {
            var a = this.paper;
            a.__set__ && a.__set__.exclude(this), V.unbind("raphael.*.*." + this.id), this.gradient && a.defs.removeChild(this.gradient), af._tear(this, a), this.node.parentNode.tagName.toLowerCase() == "a" ? this.node.parentNode.parentNode.removeChild(this.node.parentNode) : this.node.parentNode.removeChild(this.node);
            for (var d in this) {
                this[d] = typeof this[d] == "function" ? af._removedFactory(d) : null
            }
            this.removed = !0
        }
    }, P._getBBox = function() {
        if (this.node.style.display == "none") {
            this.show();
            var e = !0
        }
        var d = {};
        try {
            d = this.node.getBBox()
        } catch (f) {} finally {
            d = d || {}
        }
        e && this.hide();
        return d
    }, P.attr = function(x, w) {
        if (this.removed) {
            return this
        }
        if (x == null) {
            var v = {};
            for (var u in this.attrs) {
                this.attrs[ae](u) && (v[u] = this.attrs[u])
            }
            v.gradient && v.fill == "none" && (v.fill = v.gradient) && delete v.gradient, v.transform = this._.transform;
            return v
        }
        if (w == null && af.is(x, "string")) {
            if (x == "fill" && this.attrs.fill == "none" && this.attrs.gradient) {
                return this.attrs.gradient
            }
            if (x == "transform") {
                return this._.transform
            }
            var t = x.split(W),
                s = {};
            for (var r = 0, q = t.length; r < q; r++) {
                x = t[r], x in this.attrs ? s[x] = this.attrs[x] : af.is(this.paper.customAttributes[x], "function") ? s[x] = this.paper.customAttributes[x].def : s[x] = af._availableAttrs[x]
            }
            return q - 1 ? s : s[t[0]]
        }
        if (w == null && af.is(x, "array")) {
            s = {};
            for (r = 0, q = x.length; r < q; r++) {
                s[x[r]] = this.attr(x[r])
            }
            return s
        }
        if (w != null) {
            var k = {};
            k[x] = w
        } else {
            x != null && af.is(x, "object") && (k = x)
        }
        for (var j in k) {
            V("raphael.attr." + j + "." + this.id, this, k[j])
        }
        for (j in this.paper.customAttributes) {
            if (this.paper.customAttributes[ae](j) && k[ae](j) && af.is(this.paper.customAttributes[j], "function")) {
                var b = this.paper.customAttributes[j].apply(this, [].concat(k[j]));
                this.attrs[j] = k[j];
                for (var a in b) {
                    b[ae](a) && (k[a] = b[a])
                }
            }
        }
        G(this, k);
        return this
    }, P.toFront = function() {
        if (this.removed) {
            return this
        }
        this.node.parentNode.tagName.toLowerCase() == "a" ? this.node.parentNode.parentNode.appendChild(this.node.parentNode) : this.node.parentNode.appendChild(this.node);
        var a = this.paper;
        a.top != this && af._tofront(this, a);
        return this
    }, P.toBack = function() {
        if (this.removed) {
            return this
        }
        var a = this.node.parentNode;
        a.tagName.toLowerCase() == "a" ? a.parentNode.insertBefore(this.node.parentNode, this.node.parentNode.parentNode.firstChild) : a.firstChild != this.node && a.insertBefore(this.node, this.node.parentNode.firstChild), af._toback(this, this.paper);
        var d = this.paper;
        return this
    }, P.insertAfter = function(a) {
        if (this.removed) {
            return this
        }
        var d = a.node || a[a.length - 1].node;
        d.nextSibling ? d.parentNode.insertBefore(this.node, d.nextSibling) : d.parentNode.appendChild(this.node), af._insertafter(this, a, this.paper);
        return this
    }, P.insertBefore = function(a) {
        if (this.removed) {
            return this
        }
        var d = a.node || a[0].node;
        d.parentNode.insertBefore(this.node, d), af._insertbefore(this, a, this.paper);
        return this
    }, P.blur = function(a) {
        var h = this;
        if (+a !== 0) {
            var g = O("filter"),
                f = O("feGaussianBlur");
            h.attrs.blur = a, g.id = af.createUUID(), O(f, {
                stdDeviation: +a || 1.5
            }), g.appendChild(f), h.paper.defs.appendChild(g), h._blur = g, O(h.node, {
                filter: "url(#" + g.id + ")"
            })
        } else {
            h._blur && (h._blur.parentNode.removeChild(h._blur), delete h._blur, delete h.attrs.blur), h.node.removeAttribute("filter")
        }
    }, af._engine.circle = function(h, g, l, k) {
        var j = O("circle");
        h.canvas && h.canvas.appendChild(j);
        var i = new D(j, h);
        i.attrs = {
            cx: g,
            cy: l,
            r: k,
            fill: "none",
            stroke: "#000"
        }, i.type = "circle", O(j, i.attrs);
        return i
    }, af._engine.rect = function(j, i, p, o, n, m) {
        var l = O("rect");
        j.canvas && j.canvas.appendChild(l);
        var k = new D(l, j);
        k.attrs = {
            x: i,
            y: p,
            width: o,
            height: n,
            r: m || 0,
            rx: m || 0,
            ry: m || 0,
            fill: "none",
            stroke: "#000"
        }, k.type = "rect", O(l, k.attrs);
        return k
    }, af._engine.ellipse = function(i, h, n, m, l) {
        var k = O("ellipse");
        i.canvas && i.canvas.appendChild(k);
        var j = new D(k, i);
        j.attrs = {
            cx: h,
            cy: n,
            rx: m,
            ry: l,
            fill: "none",
            stroke: "#000"
        }, j.type = "ellipse", O(k, j.attrs);
        return j
    }, af._engine.image = function(j, i, p, o, n, m) {
        var l = O("image");
        O(l, {
            x: p,
            y: o,
            width: n,
            height: m,
            preserveAspectRatio: "none"
        }), l.setAttributeNS(S, "href", i), j.canvas && j.canvas.appendChild(l);
        var k = new D(l, j);
        k.attrs = {
            x: p,
            y: o,
            width: n,
            height: m,
            src: i
        }, k.type = "image";
        return k
    }, af._engine.text = function(a, l, k, j) {
        var i = O("text");
        a.canvas && a.canvas.appendChild(i);
        var h = new D(i, a);
        h.attrs = {
            x: l,
            y: k,
            "text-anchor": "middle",
            text: j,
            font: af._availableAttrs.font,
            stroke: "none",
            fill: "#000"
        }, h.type = "text", G(h, h.attrs);
        return h
    }, af._engine.setSize = function(d, c) {
        this.width = d || this.width, this.height = c || this.height, this.canvas.setAttribute("width", this.width), this.canvas.setAttribute("height", this.height), this._viewBox && this.setViewBox.apply(this, this._viewBox);
        return this
    }, af._engine.create = function() {
        var r = af._getContainer.apply(0, arguments),
            q = r && r.container,
            p = r.x,
            o = r.y,
            n = r.width,
            m = r.height;
        if (!q) {
            throw new Error("SVG container not found.")
        }
        var l = O("svg"),
            k = "overflow:hidden;",
            a;
        p = p || 0, o = o || 0, n = n || 512, m = m || 342, O(l, {
            height: m,
            version: 1.1,
            width: n,
            xmlns: "http://www.w3.org/2000/svg"
        }), q == 1 ? (l.style.cssText = k + "position:absolute;left:" + p + "px;top:" + o + "px", af._g.doc.body.appendChild(l), a = 1) : (l.style.cssText = k + "position:relative", q.firstChild ? q.insertBefore(l, q.firstChild) : q.appendChild(l)), q = new af._Paper, q.width = n, q.height = m, q.canvas = l, q.clear(), q._left = q._top = 0, a && (q.renderfix = function() {}), q.renderfix();
        return q
    }, af._engine.setViewBox = function(t, s, r, q, p) {
        V("raphael.setViewBox", this, this._viewBox, [t, s, r, q, p]);
        var o = Z(r / this.width, q / this.height),
            n = this.top,
            m = p ? "meet" : "xMinYMin",
            k, g;
        t == null ? (this._vbSize && (o = 1), delete this._vbSize, k = "0 0 " + this.width + T + this.height) : (this._vbSize = o, k = t + T + s + T + r + T + q), O(this.canvas, {
            viewBox: k,
            preserveAspectRatio: m
        });
        while (o && n) {
            g = "stroke-width" in n.attrs ? n.attrs["stroke-width"] : 1, n.attr({
                "stroke-width": g
            }), n._.dirty = 1, n._.dirtyT = 1, n = n.prev
        }
        this._viewBox = [t, s, r, q, !!p];
        return this
    }, af.prototype.renderfix = function() {
        var h = this.canvas,
            g = h.style,
            l;
        try {
            l = h.getScreenCTM() || h.createSVGMatrix()
        } catch (k) {
            l = h.createSVGMatrix()
        }
        var j = -l.e % 1,
            i = -l.f % 1;
        if (j || i) {
            j && (this._left = (this._left + j) % 1, g.left = this._left + "px"), i && (this._top = (this._top + i) % 1, g.top = this._top + "px")
        }
    }, af.prototype.clear = function() {
        af.eve("raphael.clear", this);
        var a = this.canvas;
        while (a.firstChild) {
            a.removeChild(a.firstChild)
        }
        this.bottom = this.top = null, (this.desc = O("desc")).appendChild(af._g.doc.createTextNode("Created with RaphaÃ«l " + af.version)), a.appendChild(this.desc), a.appendChild(this.defs = O("defs"))
    }, af.prototype.remove = function() {
        V("raphael.remove", this), this.canvas.parentNode && this.canvas.parentNode.removeChild(this.canvas);
        for (var a in this) {
            this[a] = typeof this[a] == "function" ? af._removedFactory(a) : null
        }
    };
    var N = af.st;
    for (var L in P) {
        P[ae](L) && !N[ae](L) && (N[L] = function(b) {
            return function() {
                var a = arguments;
                return this.forEach(function(d) {
                    d[b].apply(d, a)
                })
            }
        }(L))
    }
}(window.Raphael), window.Raphael.vml && function(ap) {
    var ao = "hasOwnProperty",
        an = String,
        am = parseFloat,
        al = Math,
        ak = al.round,
        aj = al.max,
        ai = al.min,
        ah = al.abs,
        ag = "fill",
        af = /[, ]+/,
        ae = ap.eve,
        ad = " progid:DXImageTransform.Microsoft",
        ac = " ",
        ab = "",
        aa = {
            M: "m",
            L: "l",
            C: "c",
            Z: "x",
            m: "t",
            l: "r",
            c: "v",
            z: "x"
        },
        Y = /([clmz]),?([^clmz]*)/gi,
        W = / progid:\S+Blur\([^\)]+\)/g,
        U = /-?[^,\s-]+/g,
        S = "position:absolute;left:0;top:0;width:1px;height:1px",
        Q = 21600,
        O = {
            path: 1,
            rect: 1,
            image: 1
        },
        M = {
            circle: 1,
            ellipse: 1
        },
        K = function(v) {
            var u = /[ahqstv]/ig,
                t = ap._pathToAbsolute;
            an(v).match(u) && (t = ap._path2curve), u = /[clmz]/g;
            if (t == ap._pathToAbsolute && !an(v).match(u)) {
                var s = an(v).replace(Y, function(i, h, m) {
                    var l = [],
                        k = h.toLowerCase() == "m",
                        j = aa[h];
                    m.replace(U, function(b) {
                        k && l.length == 2 && (j += l + aa[h == "m" ? "l" : "L"], l = []), l.push(ak(b * Q))
                    });
                    return j + l
                });
                return s
            }
            var q = t(v),
                p, o;
            s = [];
            for (var n = 0, f = q.length; n < f; n++) {
                p = q[n], o = q[n][0].toLowerCase(), o == "z" && (o = "x");
                for (var c = 1, a = p.length; c < a; c++) {
                    o += ak(p[c] * Q) + (c != a - 1 ? "," : ab)
                }
                s.push(o)
            }
            return s.join(ac)
        },
        J = function(a, h, g) {
            var f = ap.matrix();
            f.rotate(-a, 0.5, 0.5);
            return {
                dx: f.x(h, g),
                dy: f.y(h, g)
            }
        },
        I = function(ar, aq, H, G, F, E) {
            var D = ar._,
                C = ar.matrix,
                B = D.fillpos,
                A = ar.node,
                z = A.style,
                y = 1,
                x = "",
                w, u = Q / aq,
                n = Q / H;
            z.visibility = "hidden";
            if (!!aq && !!H) {
                A.coordsize = ah(u) + ac + ah(n), z.rotation = E * (aq * H < 0 ? -1 : 1);
                if (E) {
                    var j = J(E, G, F);
                    G = j.dx, F = j.dy
                }
                aq < 0 && (x += "x"), H < 0 && (x += " y") && (y = -1), z.flip = x, A.coordorigin = G * -u + ac + F * -n;
                if (B || D.fillsize) {
                    var i = A.getElementsByTagName(ag);
                    i = i && i[0], A.removeChild(i), B && (j = J(E, C.x(B[0], B[1]), C.y(B[0], B[1])), i.position = j.dx * y + ac + j.dy * y), D.fillsize && (i.size = D.fillsize[0] * ah(aq) + ac + D.fillsize[1] * ah(H)), A.appendChild(i)
                }
                z.visibility = "visible"
            }
        };
    ap.toString = function() {
        return "Your browser doesnâ€™t support SVG. Falling down to VML.\nYou are running RaphaÃ«l " + this.version
    };
    var Z = function(t, s, r) {
            var q = an(s).toLowerCase().split("-"),
                p = r ? "end" : "start",
                o = q.length,
                n = "classic",
                m = "medium",
                l = "medium";
            while (o--) {
                switch (q[o]) {
                    case "block":
                    case "classic":
                    case "oval":
                    case "diamond":
                    case "open":
                    case "none":
                        n = q[o];
                        break;
                    case "wide":
                    case "narrow":
                        l = q[o];
                        break;
                    case "long":
                    case "short":
                        m = q[o]
                }
            }
            var c = t.node.getElementsByTagName("stroke")[0];
            c[p + "arrow"] = n, c[p + "arrowlength"] = m, c[p + "arrowwidth"] = l
        },
        X = function(aF, aE) {
            aF.attrs = aF.attrs || {};
            var aD = aF.node,
                aC = aF.attrs,
                aB = aD.style,
                aA, ay = O[aF.type] && (aE.x != aC.x || aE.y != aC.y || aE.width != aC.width || aE.height != aC.height || aE.cx != aC.cx || aE.cy != aC.cy || aE.rx != aC.rx || aE.ry != aC.ry || aE.r != aC.r),
                aw = M[aF.type] && (aC.cx != aE.cx || aC.cy != aE.cy || aC.r != aE.r || aC.rx != aE.rx || aC.ry != aE.ry),
                av = aF;
            for (var F in aE) {
                aE[ao](F) && (aC[F] = aE[F])
            }
            ay && (aC.path = ap._getPath[aF.type](aF), aF._.dirty = 1), aE.href && (aD.href = aE.href), aE.title && (aD.title = aE.title), aE.target && (aD.target = aE.target), aE.cursor && (aB.cursor = aE.cursor), "blur" in aE && aF.blur(aE.blur);
            if (aE.path && aF.type == "path" || ay) {
                aD.path = K(~an(aC.path).toLowerCase().indexOf("r") ? ap._pathToAbsolute(aC.path) : aC.path), aF.type == "image" && (aF._.fillpos = [aC.x, aC.y], aF._.fillsize = [aC.width, aC.height], I(aF, 1, 1, 0, 0, 0))
            }
            "transform" in aE && aF.transform(aE.transform);
            if (aw) {
                var az = +aC.cx,
                    ax = +aC.cy,
                    au = +aC.rx || +aC.r || 0,
                    at = +aC.ry || +aC.r || 0;
                aD.path = ap.format("ar{0},{1},{2},{3},{4},{1},{4},{1}x", ak((az - au) * Q), ak((ax - at) * Q), ak((az + au) * Q), ak((ax + at) * Q), ak(az * Q))
            }
            if ("clip-rect" in aE) {
                var ar = an(aE["clip-rect"]).split(af);
                if (ar.length == 4) {
                    ar[2] = +ar[2] + +ar[0], ar[3] = +ar[3] + +ar[1];
                    var aq = aD.clipRect || ap._g.doc.createElement("div"),
                        C = aq.style;
                    C.clip = ap.format("rect({1}px {2}px {3}px {0}px)", ar), aD.clipRect || (C.position = "absolute", C.top = 0, C.left = 0, C.width = aF.paper.width + "px", C.height = aF.paper.height + "px", aD.parentNode.insertBefore(aq, aD), aq.appendChild(aD), aD.clipRect = aq)
                }
                aE["clip-rect"] || aD.clipRect && (aD.clipRect.style.clip = "auto")
            }
            if (aF.textpath) {
                var A = aF.textpath.style;
                aE.font && (A.font = aE.font), aE["font-family"] && (A.fontFamily = '"' + aE["font-family"].split(",")[0].replace(/^['"]+|['"]+$/g, ab) + '"'), aE["font-size"] && (A.fontSize = aE["font-size"]), aE["font-weight"] && (A.fontWeight = aE["font-weight"]), aE["font-style"] && (A.fontStyle = aE["font-style"])
            }
            "arrow-start" in aE && Z(av, aE["arrow-start"]), "arrow-end" in aE && Z(av, aE["arrow-end"], 1);
            if (aE.opacity != null || aE["stroke-width"] != null || aE.fill != null || aE.src != null || aE.stroke != null || aE["stroke-width"] != null || aE["stroke-opacity"] != null || aE["fill-opacity"] != null || aE["stroke-dasharray"] != null || aE["stroke-miterlimit"] != null || aE["stroke-linejoin"] != null || aE["stroke-linecap"] != null) {
                var z = aD.getElementsByTagName(ag),
                    x = !1;
                z = z && z[0], !z && (x = z = P(ag)), aF.type == "image" && aE.src && (z.src = aE.src), aE.fill && (z.on = !0);
                if (z.on == null || aE.fill == "none" || aE.fill === null) {
                    z.on = !1
                }
                if (z.on && aE.fill) {
                    var w = an(aE.fill).match(ap._ISURL);
                    if (w) {
                        z.parentNode == aD && aD.removeChild(z), z.rotate = !0, z.src = w[1], z.type = "tile";
                        var v = aF.getBBox(1);
                        z.position = v.x + ac + v.y, aF._.fillpos = [v.x, v.y], ap._preload(w[1], function() {
                            aF._.fillsize = [this.offsetWidth, this.offsetHeight]
                        })
                    } else {
                        z.color = ap.getRGB(aE.fill).hex, z.src = ab, z.type = "solid", ap.getRGB(aE.fill).error && (av.type in {
                            circle: 1,
                            ellipse: 1
                        } || an(aE.fill).charAt() != "r") && V(av, aE.fill, z) && (aC.fill = "none", aC.gradient = aE.fill, z.rotate = !1)
                    }
                }
                if ("fill-opacity" in aE || "opacity" in aE) {
                    var u = ((+aC["fill-opacity"] + 1 || 2) - 1) * ((+aC.opacity + 1 || 2) - 1) * ((+ap.getRGB(aE.fill).o + 1 || 2) - 1);
                    u = ai(aj(u, 0), 1), z.opacity = u, z.src && (z.color = "none")
                }
                aD.appendChild(z);
                var n = aD.getElementsByTagName("stroke") && aD.getElementsByTagName("stroke")[0],
                    h = !1;
                !n && (h = n = P("stroke"));
                if (aE.stroke && aE.stroke != "none" || aE["stroke-width"] || aE["stroke-opacity"] != null || aE["stroke-dasharray"] || aE["stroke-miterlimit"] || aE["stroke-linejoin"] || aE["stroke-linecap"]) {
                    n.on = !0
                }(aE.stroke == "none" || aE.stroke === null || n.on == null || aE.stroke == 0 || aE["stroke-width"] == 0) && (n.on = !1);
                var g = ap.getRGB(aE.stroke);
                n.on && aE.stroke && (n.color = g.hex), u = ((+aC["stroke-opacity"] + 1 || 2) - 1) * ((+aC.opacity + 1 || 2) - 1) * ((+g.o + 1 || 2) - 1);
                var f = (am(aE["stroke-width"]) || 1) * 0.75;
                u = ai(aj(u, 0), 1), aE["stroke-width"] == null && (f = aC["stroke-width"]), aE["stroke-width"] && (n.weight = f), f && f < 1 && (u *= f) && (n.weight = 1), n.opacity = u, aE["stroke-linejoin"] && (n.joinstyle = aE["stroke-linejoin"] || "miter"), n.miterlimit = aE["stroke-miterlimit"] || 8, aE["stroke-linecap"] && (n.endcap = aE["stroke-linecap"] == "butt" ? "flat" : aE["stroke-linecap"] == "square" ? "square" : "round");
                if (aE["stroke-dasharray"]) {
                    var d = {
                        "-": "shortdash",
                        ".": "shortdot",
                        "-.": "shortdashdot",
                        "-..": "shortdashdotdot",
                        ". ": "dot",
                        "- ": "dash",
                        "--": "longdash",
                        "- .": "dashdot",
                        "--.": "longdashdot",
                        "--..": "longdashdotdot"
                    };
                    n.dashstyle = d[ao](aE["stroke-dasharray"]) ? d[aE["stroke-dasharray"]] : ab
                }
                h && aD.appendChild(n)
            }
            if (av.type == "text") {
                av.paper.canvas.style.display = ab;
                var c = av.paper.span,
                    b = 100,
                    a = aC.font && aC.font.match(/\d+(?:\.\d*)?(?=px)/);
                aB = c.style, aC.font && (aB.font = aC.font), aC["font-family"] && (aB.fontFamily = aC["font-family"]), aC["font-weight"] && (aB.fontWeight = aC["font-weight"]), aC["font-style"] && (aB.fontStyle = aC["font-style"]), a = am(aC["font-size"] || a && a[0]) || 10, aB.fontSize = a * b + "px", av.textpath.string && (c.innerHTML = an(av.textpath.string).replace(/</g, "&#60;").replace(/&/g, "&#38;").replace(/\n/g, "<br>"));
                var j = c.getBoundingClientRect();
                av.W = aC.w = (j.right - j.left) / b, av.H = aC.h = (j.bottom - j.top) / b, av.X = aC.x, av.Y = aC.y + av.H / 2, ("x" in aE || "y" in aE) && (av.path.v = ap.format("m{0},{1}l{2},{1}", ak(aC.x * Q), ak(aC.y * Q), ak(aC.x * Q) + 1));
                var aG = ["x", "y", "text", "font", "font-family", "font-weight", "font-style", "font-size"];
                for (var o = 0, k = aG.length; o < k; o++) {
                    if (aG[o] in aE) {
                        av._.dirty = 1;
                        break
                    }
                }
                switch (aC["text-anchor"]) {
                    case "start":
                        av.textpath.style["v-text-align"] = "left", av.bbx = av.W / 2;
                        break;
                    case "end":
                        av.textpath.style["v-text-align"] = "right", av.bbx = -av.W / 2;
                        break;
                    default:
                        av.textpath.style["v-text-align"] = "center", av.bbx = 0
                }
                av.textpath.style["v-text-kern"] = !0
            }
        },
        V = function(z, y, x) {
            z.attrs = z.attrs || {};
            var w = z.attrs,
                v = Math.pow,
                u, o, n = "linear",
                e = ".5 .5";
            z.attrs.gradient = y, y = an(y).replace(ap._radial_gradient, function(g, f, h) {
                n = "radial", f && h && (f = am(f), h = am(h), v(f - 0.5, 2) + v(h - 0.5, 2) > 0.25 && (h = al.sqrt(0.25 - v(f - 0.5, 2)) * ((h > 0.5) * 2 - 1) + 0.5), e = f + ac + h);
                return ab
            }), y = y.split(/\s*\-\s*/);
            if (n == "linear") {
                var d = y.shift();
                d = -am(d);
                if (isNaN(d)) {
                    return null
                }
            }
            var c = ap._parseDots(y);
            if (!c) {
                return null
            }
            z = z.shape || z.node;
            if (c.length) {
                z.removeChild(x), x.on = !0, x.method = "none", x.color = c[0].color, x.color2 = c[c.length - 1].color;
                var a = [];
                for (var B = 0, A = c.length; B < A; B++) {
                    c[B].offset && a.push(c[B].offset + ac + c[B].color)
                }
                x.colors = a.length ? a.join() : "0% " + x.color, n == "radial" ? (x.type = "gradientTitle", x.focus = "100%", x.focussize = "0 0", x.focusposition = e, x.angle = 0) : (x.type = "gradient", x.angle = (270 - d) % 360), z.appendChild(x)
            }
            return 1
        },
        T = function(a, d) {
            this[0] = this.node = a, a.raphael = !0, this.id = ap._oid++, a.raphaelid = this.id, this.X = 0, this.Y = 0, this.attrs = {}, this.paper = d, this.matrix = ap.matrix(), this._ = {
                transform: [],
                sx: 1,
                sy: 1,
                dx: 0,
                dy: 0,
                deg: 0,
                dirty: 1,
                dirtyT: 1
            }, !d.bottom && (d.bottom = this), this.prev = d.top, d.top && (d.top.next = this), d.top = this, this.next = null
        },
        R = ap.el;
    T.prototype = R, R.constructor = T, R.transform = function(B) {
        if (B == null) {
            return this._.transform
        }
        var A = this.paper._viewBoxShift,
            z = A ? "s" + [A.scale, A.scale] + "-1-1t" + [A.dx, A.dy] : ab,
            y;
        A && (y = B = an(B).replace(/\.{3}|\u2026/g, this._.transform || ab)), ap._extractTransform(this, z + B);
        var x = this.matrix.clone(),
            w = this.skew,
            v = this.node,
            u, t = ~an(this.attrs.fill).indexOf("-"),
            s = !an(this.attrs.fill).indexOf("url(");
        x.translate(-0.5, -0.5);
        if (s || t || this.type == "image") {
            w.matrix = "1 0 0 1", w.offset = "0 0", u = x.split();
            if (t && u.noRotation || !u.isSimple) {
                v.style.filter = x.toFilter();
                var o = this.getBBox(),
                    n = this.getBBox(1),
                    c = o.x - n.x,
                    a = o.y - n.y;
                v.coordorigin = c * -Q + ac + a * -Q, I(this, 1, 1, c, a, 0)
            } else {
                v.style.filter = ab, I(this, u.scalex, u.scaley, u.dx, u.dy, u.rotate)
            }
        } else {
            v.style.filter = ab, w.matrix = an(x), w.offset = x.offset()
        }
        y && (this._.transform = y);
        return this
    }, R.rotate = function(d, c, h) {
        if (this.removed) {
            return this
        }
        if (d != null) {
            d = an(d).split(af), d.length - 1 && (c = am(d[1]), h = am(d[2])), d = am(d[0]), h == null && (c = h);
            if (c == null || h == null) {
                var g = this.getBBox(1);
                c = g.x + g.width / 2, h = g.y + g.height / 2
            }
            this._.dirtyT = 1, this.transform(this._.transform.concat([
                ["r", d, c, h]
            ]));
            return this
        }
    }, R.translate = function(d, c) {
        if (this.removed) {
            return this
        }
        d = an(d).split(af), d.length - 1 && (c = am(d[1])), d = am(d[0]) || 0, c = +c || 0, this._.bbox && (this._.bbox.x += d, this._.bbox.y += c), this.transform(this._.transform.concat([
            ["t", d, c]
        ]));
        return this
    }, R.scale = function(d, c, j, i) {
        if (this.removed) {
            return this
        }
        d = an(d).split(af), d.length - 1 && (c = am(d[1]), j = am(d[2]), i = am(d[3]), isNaN(j) && (j = null), isNaN(i) && (i = null)), d = am(d[0]), c == null && (c = d), i == null && (j = i);
        if (j == null || i == null) {
            var h = this.getBBox(1)
        }
        j = j == null ? h.x + h.width / 2 : j, i = i == null ? h.y + h.height / 2 : i, this.transform(this._.transform.concat([
            ["s", d, c, j, i]
        ])), this._.dirtyT = 1;
        return this
    }, R.hide = function() {
        !this.removed && (this.node.style.display = "none");
        return this
    }, R.show = function() {
        !this.removed && (this.node.style.display = ab);
        return this
    }, R._getBBox = function() {
        if (this.removed) {
            return {}
        }
        return {
            x: this.X + (this.bbx || 0) - this.W / 2,
            y: this.Y - this.H,
            width: this.W,
            height: this.H
        }
    }, R.remove = function() {
        if (!this.removed && !!this.node.parentNode) {
            this.paper.__set__ && this.paper.__set__.exclude(this), ap.eve.unbind("raphael.*.*." + this.id), ap._tear(this, this.paper), this.node.parentNode.removeChild(this.node), this.shape && this.shape.parentNode.removeChild(this.shape);
            for (var a in this) {
                this[a] = typeof this[a] == "function" ? ap._removedFactory(a) : null
            }
            this.removed = !0
        }
    }, R.attr = function(x, w) {
        if (this.removed) {
            return this
        }
        if (x == null) {
            var v = {};
            for (var u in this.attrs) {
                this.attrs[ao](u) && (v[u] = this.attrs[u])
            }
            v.gradient && v.fill == "none" && (v.fill = v.gradient) && delete v.gradient, v.transform = this._.transform;
            return v
        }
        if (w == null && ap.is(x, "string")) {
            if (x == ag && this.attrs.fill == "none" && this.attrs.gradient) {
                return this.attrs.gradient
            }
            var t = x.split(af),
                s = {};
            for (var r = 0, l = t.length; r < l; r++) {
                x = t[r], x in this.attrs ? s[x] = this.attrs[x] : ap.is(this.paper.customAttributes[x], "function") ? s[x] = this.paper.customAttributes[x].def : s[x] = ap._availableAttrs[x]
            }
            return l - 1 ? s : s[t[0]]
        }
        if (this.attrs && w == null && ap.is(x, "array")) {
            s = {};
            for (r = 0, l = x.length; r < l; r++) {
                s[x[r]] = this.attr(x[r])
            }
            return s
        }
        var k;
        w != null && (k = {}, k[x] = w), w == null && ap.is(x, "object") && (k = x);
        for (var j in k) {
            ae("raphael.attr." + j + "." + this.id, this, k[j])
        }
        if (k) {
            for (j in this.paper.customAttributes) {
                if (this.paper.customAttributes[ao](j) && k[ao](j) && ap.is(this.paper.customAttributes[j], "function")) {
                    var b = this.paper.customAttributes[j].apply(this, [].concat(k[j]));
                    this.attrs[j] = k[j];
                    for (var a in b) {
                        b[ao](a) && (k[a] = b[a])
                    }
                }
            }
            k.text && this.type == "text" && (this.textpath.string = k.text), X(this, k)
        }
        return this
    }, R.toFront = function() {
        !this.removed && this.node.parentNode.appendChild(this.node), this.paper && this.paper.top != this && ap._tofront(this, this.paper);
        return this
    }, R.toBack = function() {
        if (this.removed) {
            return this
        }
        this.node.parentNode.firstChild != this.node && (this.node.parentNode.insertBefore(this.node, this.node.parentNode.firstChild), ap._toback(this, this.paper));
        return this
    }, R.insertAfter = function(a) {
        if (this.removed) {
            return this
        }
        a.constructor == ap.st.constructor && (a = a[a.length - 1]), a.node.nextSibling ? a.node.parentNode.insertBefore(this.node, a.node.nextSibling) : a.node.parentNode.appendChild(this.node), ap._insertafter(this, a, this.paper);
        return this
    }, R.insertBefore = function(a) {
        if (this.removed) {
            return this
        }
        a.constructor == ap.st.constructor && (a = a[0]), a.node.parentNode.insertBefore(this.node, a.node), ap._insertbefore(this, a, this.paper);
        return this
    }, R.blur = function(a) {
        var f = this.node.runtimeStyle,
            e = f.filter;
        e = e.replace(W, ab), +a !== 0 ? (this.attrs.blur = a, f.filter = e + ac + ad + ".Blur(pixelradius=" + (+a || 1.5) + ")", f.margin = ap.format("-{0}px 0 0 -{0}px", ak(+a || 1.5))) : (f.filter = e, f.margin = 0, delete this.attrs.blur)
    }, ap._engine.path = function(h, g) {
        var l = P("shape");
        l.style.cssText = S, l.coordsize = Q + ac + Q, l.coordorigin = g.coordorigin;
        var k = new T(l, g),
            j = {
                fill: "none",
                stroke: "#000"
            };
        h && (j.path = h), k.type = "path", k.path = [], k.Path = ab, X(k, j), g.canvas.appendChild(l);
        var i = P("skew");
        i.on = !0, l.appendChild(i), k.skew = i, k.transform(ab);
        return k
    }, ap._engine.rect = function(r, q, p, o, n, m) {
        var l = ap._rectPath(q, p, o, n, m),
            k = r.path(l),
            a = k.attrs;
        k.X = a.x = q, k.Y = a.y = p, k.W = a.width = o, k.H = a.height = n, a.r = m, a.path = l, k.type = "rect";
        return k
    }, ap._engine.ellipse = function(i, h, n, m, l) {
        var k = i.path(),
            j = k.attrs;
        k.X = h - m, k.Y = n - l, k.W = m * 2, k.H = l * 2, k.type = "ellipse", X(k, {
            cx: h,
            cy: n,
            rx: m,
            ry: l
        });
        return k
    }, ap._engine.circle = function(h, g, l, k) {
        var j = h.path(),
            i = j.attrs;
        j.X = g - k, j.Y = l - k, j.W = j.H = k * 2, j.type = "circle", X(j, {
            cx: g,
            cy: l,
            r: k
        });
        return j
    }, ap._engine.image = function(v, u, t, s, r, q) {
        var p = ap._rectPath(t, s, r, q),
            o = v.path(p).attr({
                stroke: "none"
            }),
            n = o.attrs,
            j = o.node,
            a = j.getElementsByTagName(ag)[0];
        n.src = u, o.X = n.x = t, o.Y = n.y = s, o.W = n.width = r, o.H = n.height = q, n.path = p, o.type = "image", a.parentNode == j && j.removeChild(a), a.rotate = !0, a.src = u, a.type = "tile", o._.fillpos = [t, s], o._.fillsize = [r, q], j.appendChild(a), I(o, 1, 1, 0, 0, 0);
        return o
    }, ap._engine.text = function(t, s, r, q) {
        var p = P("shape"),
            o = P("path"),
            n = P("textpath");
        s = s || 0, r = r || 0, q = q || "", o.v = ap.format("m{0},{1}l{2},{1}", ak(s * Q), ak(r * Q), ak(s * Q) + 1), o.textpathok = !0, n.string = an(q), n.on = !0, p.style.cssText = S, p.coordsize = Q + ac + Q, p.coordorigin = "0 0";
        var f = new T(p, t),
            c = {
                fill: "#000",
                stroke: "none",
                font: ap._availableAttrs.font,
                text: q
            };
        f.shape = p, f.path = o, f.textpath = n, f.type = "text", f.attrs.text = an(q), f.attrs.x = s, f.attrs.y = r, f.attrs.w = 1, f.attrs.h = 1, X(f, c), p.appendChild(n), p.appendChild(o), t.canvas.appendChild(p);
        var a = P("skew");
        a.on = !0, p.appendChild(a), f.skew = a, f.transform(ab);
        return f
    }, ap._engine.setSize = function(a, f) {
        var e = this.canvas.style;
        this.width = a, this.height = f, a == +a && (a += "px"), f == +f && (f += "px"), e.width = a, e.height = f, e.clip = "rect(0 " + a + " " + f + " 0)", this._viewBox && ap._engine.setViewBox.apply(this, this._viewBox);
        return this
    }, ap._engine.setViewBox = function(t, s, r, q, p) {
        ap.eve("raphael.setViewBox", this, this._viewBox, [t, s, r, q, p]);
        var o = this.width,
            n = this.height,
            m = 1 / aj(r / o, q / n),
            g, a;
        p && (g = n / q, a = o / r, r * g < o && (t -= (o - r * g) / 2 / g), q * a < n && (s -= (n - q * a) / 2 / a)), this._viewBox = [t, s, r, q, !!p], this._viewBoxShift = {
            dx: -t,
            dy: -s,
            scale: m
        }, this.forEach(function(b) {
            b.transform("...")
        });
        return this
    };
    var P;
    ap._engine.initWin = function(e) {
        var d = e.document;
        d.createStyleSheet().addRule(".rvml", "behavior:url(#default#VML)");
        try {
            !d.namespaces.rvml && d.namespaces.add("rvml", "urn:schemas-microsoft-com:vml"), P = function(b) {
                return d.createElement("<rvml:" + b + ' class="rvml">')
            }
        } catch (f) {
            P = function(b) {
                return d.createElement("<" + b + ' xmlns="urn:schemas-microsoft.com:vml" class="rvml">')
            }
        }
    }, ap._engine.initWin(ap._g.win), ap._engine.create = function() {
        var t = ap._getContainer.apply(0, arguments),
            s = t.container,
            r = t.height,
            q, p = t.width,
            o = t.x,
            n = t.y;
        if (!s) {
            throw new Error("VML container not found.")
        }
        var m = new ap._Paper,
            l = m.canvas = ap._g.doc.createElement("div"),
            a = l.style;
        o = o || 0, n = n || 0, p = p || 512, r = r || 342, m.width = p, m.height = r, p == +p && (p += "px"), r == +r && (r += "px"), m.coordsize = Q * 1000 + ac + Q * 1000, m.coordorigin = "0 0", m.span = ap._g.doc.createElement("span"), m.span.style.cssText = "position:absolute;left:-9999em;top:-9999em;padding:0;margin:0;line-height:1;", l.appendChild(m.span), a.cssText = ap.format("top:0;left:0;width:{0};height:{1};display:inline-block;position:relative;clip:rect(0 {0} {1} 0);overflow:hidden", p, r), s == 1 ? (ap._g.doc.body.appendChild(l), a.left = o + "px", a.top = n + "px", a.position = "absolute") : s.firstChild ? s.insertBefore(l, s.firstChild) : s.appendChild(l), m.renderfix = function() {};
        return m
    }, ap.prototype.clear = function() {
        ap.eve("raphael.clear", this), this.canvas.innerHTML = ab, this.span = ap._g.doc.createElement("span"), this.span.style.cssText = "position:absolute;left:-9999em;top:-9999em;padding:0;margin:0;line-height:1;display:inline;", this.canvas.appendChild(this.span), this.bottom = this.top = null
    }, ap.prototype.remove = function() {
        ap.eve("raphael.remove", this), this.canvas.parentNode.removeChild(this.canvas);
        for (var a in this) {
            this[a] = typeof this[a] == "function" ? ap._removedFactory(a) : null
        }
        return !0
    };
    var N = ap.st;
    for (var L in R) {
        R[ao](L) && !N[ao](L) && (N[L] = function(b) {
            return function() {
                var a = arguments;
                return this.forEach(function(d) {
                    d[b].apply(d, a)
                })
            }
        }(L))
    }
}(window.Raphael);
(function(d, c, b, e) {
    var a = function(g, f) {
        this.element = g;
        this.$elem = d(g);
        this.options = f;
        this.metadata = this.$elem.data("options")
    };
    a.prototype = {
        defaults: {
            paper: "nytmm_paper",
            start: ["pointA", "pointB"],
            end: ["pointB", "pointC"],
            startoffset: {
                x: "right",
                y: ""
            },
            endoffset: {
                x: "left",
                y: ""
            },
            stroke_color: "#333333",
            stroke_width: 2,
            active_color: "#F0F4F5",
            onCompleteEachSet: function(f) {
                d.log(f)
            },
            onCompleteAll: function(f) {
                d.log(f)
            },
            onCompleteLine: function(f, g) {
                d.log(g)
            }
        },
        init: function() {
            var f = this;
            this.config = d.extend({}, this.defaults, this.options, this.metadata);
            this.resetData();
            this.$paper = d("#" + this.config.paper);
            this.paper = Raphael(this.config.paper, this.$paper.width(), this.$paper.height());
            this.$starts = _.map(this.config.start, function(g) {
                return f.$elem.find("." + g)
            });
            this.$ends = _.map(this.config.end, function(g) {
                return f.$elem.find("." + g)
            });
            this.$paper.bind("touchstart", function(g) {
                g.preventDefault()
            });
            this.$paper.bind("mousemove mouseup mousedown touchmove", function(s) {
                var m = s.type === "touchmove" ? s.originalEvent.touches[0].pageX : s.pageX;
                var l = s.type === "touchmove" ? s.originalEvent.touches[0].pageY : s.pageY;
                var h = m - f.$paper.offset().left;
                var g = l - f.$paper.offset().top;
                var j = (s.type === "touchmove" || s.type === "mousedown") ? f.detectIntersect(f.$starts, m, l) : null;
                var k = (s.type == "touchmove" || s.type === "mouseup") ? f.detectIntersect(f.$ends, m, l) : null;
                if (s.type === "mouseup") {
                    var t = f.detectIntersect(f.$starts, m, l);
                    if (t !== null && f.startedId !== null && f.compareIds(t, f.startedId) === true || f.startedId !== null && k === null) {
                        if (!f.currentStartEl().hasClass("nytmm_matched")) {
                            f.removeActive([f.currentStartEl()]);
                            f.clearCurrentLine()
                        }
                    }
                }
                if (f.startedId === null) {
                    if (j !== null) {
                        f.startedId = j;
                        var A = f.currentStartEl();
                        if (!A.hasClass("nytmm_matched")) {
                            var r = (f.config.startoffset.x !== "") ? (f.config.startoffset.x == "right") ? A.outerWidth() / 2 : -(A.outerWidth() / 2) : 0;
                            var q = (f.config.startoffset.y !== "") ? (f.config.startoffset.y == "bottom") ? A.height() / 2 : -(A.height() / 2) : 0;
                            var v = A.offset().left + A.outerWidth() / 2 - f.$paper.offset().left + r;
                            var u = A.offset().top + A.height() / 2 - f.$paper.offset().top + q;
                            var n = f.Line(v, u, v, u, f.paper);
                            f.lines[f.startedId.set_index][f.startedId.el_index] = n;
                            f.setActive(A)
                        }
                    }
                } else {
                    if (k !== null) {
                        var i = f.$ends[k.set_index].eq(k.el_index);
                        if (!i.hasClass("nytmm_ended") && k.set_index == f.startedId.set_index && k.which != f.startedId.which) {
                            var z = (f.config.endoffset.x !== "") ? (f.config.endoffset.x == "right") ? i.width() / 2 : -(i.width() / 2) : 0;
                            var w = (f.config.endoffset.y !== "") ? (f.config.endoffset.y == "bottom") ? i.height() / 2 : -(i.height() / 2) : 0;
                            var p = i.offset().left + i.width() / 2 - f.$paper.offset().left + z;
                            var o = i.offset().top + i.height() / 2 - f.$paper.offset().top + w;
                            f.currentLine().updateEnd(p, o);
                            f.setActive([i]);
                            f.createMatch(k)
                        } else {
                            f.removeActive([f.currentStartEl()]);
                            f.clearCurrentLine()
                        }
                    } else {
                        if (f.currentLine() !== e) {
                            if (!f.currentStartEl().hasClass("nytmm_matched")) {
                                f.currentLine().updateEnd(h, g)
                            } else {
                                f.startedId = null
                            }
                        }
                    }
                }
                s.preventDefault()
            });
            return this
        },
        compareIds: function(i, h) {
            var g = 0,
                f = false;
            _.each(i, function(j, k) {
                if (j == h[k]) {
                    g++
                }
            });
            if (g == i.length) {
                f = true
            }
            return f
        },
        currentStartEl: function() {
            return this.$starts[this.startedId.set_index].eq(this.startedId.el_index)
        },
        currentLine: function() {
            return this.lines[this.startedId.set_index][this.startedId.el_index]
        },
        clearCurrentLine: function() {
            if (this.currentLine()) {
                this.currentLine().remove()
            }
            this.startedId = null
        },
        clearLine: function(f, h, i) {
            var g = this.lines[f][h];
            g.remove();
            this.$starts[f].eq(h).removeClass("nytmm_matched").css("backgroundColor", "#ffffff");
            this.$ends[f].eq(i).removeClass("nytmm_ended").css("backgroundColor", "#ffffff")
        },
        clearAllLines: function() {
            _.each(this.lines, function(g, f) {
                _.each(g, function(h, i) {
                    h.remove()
                })
            })
        },
        setActive: function(f) {
            var g = this;
            _.each(f, function(i, h) {
                $j(i).animate({
                    backgroundColor: g.config.active_color
                }, 500)
            })
        },
        removeActive: function(f) {
            var g = this;
            _.each(f, function(i, h) {
                $j(i).animate({
                    backgroundColor: "#ffffff"
                }, 500)
            })
        },
        createMatch: function(f) {
            if (this.startedId !== null) {
                this.matches[this.startedId.set_index][this.startedId.el_index] = {
                    start: {
                        eq: this.startedId.el_index,
                        el_class: this.config.start[this.startedId.set_index],
                        el_id: this.startedId.id
                    },
                    end: {
                        eq: f.el_index,
                        el_class: this.config.end[this.startedId.set_index],
                        el_id: f.id
                    }
                };
                this.currentStartEl().addClass("nytmm_matched");
                this.$ends[f.set_index].eq(f.el_index).addClass("nytmm_ended");
                if (_.without(this.matches[this.startedId.set_index], e).length == this.$starts[this.startedId.set_index].length) {
                    this.config.onCompleteEachSet(this.matches[this.startedId.set_index]);
                    if (_.without(this.matches, e).length == this.$starts.length) {
                        this.config.onCompleteAll(this.matches)
                    }
                }
                this.config.onCompleteLine(this.startedId.set_index, this.matches[this.startedId.set_index][this.startedId.el_index]);
                this.startedId = null
            }
        },
        detectIntersect: function(h, g, j) {
            var f = null,
                i = (h == this.$starts) ? "starts" : "ends";
            _.each(h, function(l, k) {
                l.each(function(o) {
                    var n = d(this).offset().left,
                        q = n + d(this).width(),
                        m = d(this).offset().top,
                        p = m + d(this).height(),
                        r = (d(this).data()) ? d(this).data().id : "";
                    if (g <= q && g >= n && j <= p && j >= m) {
                        f = {
                            set_index: k,
                            el_index: o,
                            which: i,
                            id: r
                        };
                        return (false)
                    }
                })
            });
            return f
        },
        resetData: function() {
            this.startedId = null;
            this.matches = _.map(this.config.start, function(f) {
                return []
            });
            this.lines = _.map(this.config.start, function(f) {
                return []
            })
        },
        Line: function(k, j, n, l, o) {
            var g = {
                    x: k,
                    y: j
                },
                i = {
                    x: n,
                    y: l
                };
            var p = function() {
                return "M" + g.x + " " + g.y + " L" + i.x + " " + i.y
            };
            var h = o.path(p());
            var f = function(q, r) {
                h.attr("stroke", q);
                h.attr("stroke-width", r)
            };
            f(this.config.stroke_color, this.config.stroke_width);
            var m = function() {
                h.attr("path", p())
            };
            return {
                updateStart: function(q, r) {
                    g.x = q;
                    g.y = r;
                    m();
                    return this
                },
                updateEnd: function(q, r) {
                    i.x = q;
                    i.y = r;
                    m();
                    return this
                },
                remove: function() {
                    h.remove()
                },
                updateAttr: function(q, r) {
                    f(q, r);
                    m()
                }
            }
        },
        clearAll: function() {
            var f = this;
            this.clearAllLines();
            this.resetData();
            _.each(this.config.start, function(h, g) {
                f.$elem.find("." + h).removeClass("nytmm_matched").css("backgroundColor", "#ffffff")
            });
            _.each(this.config.end, function(h, g) {
                f.$elem.find("." + h).removeClass("nytmm_ended").css("backgroundColor", "#ffffff")
            })
        }
    };
    a.defaults = a.prototype.defaults;
    d.fn.drawline = function(f) {
        return this.each(function() {
            d(this).data("drawline", new a(this, f).init())
        })
    }
})(jQuery || NYTD.jQuery, window, document);
(function(a, c, b) {
    if (a !== b && a.Quizinator === b) {
        a.Quizinator = function(d, f, e) {
            this.$parent = c(d);
            this.options = c.extend(true, {
                templates: {
                    question: '{{#questions}}<div class="nytmm_qz_question clearfix">{{#media}}<div class="nytmm_qz_media">{{{media.html}}}</div>{{#media.credit}}<div class="nytmm_credit">{{media.credit}}</div>{{/media.credit}}{{#media.caption}}<div class="nytmm_caption">{{media.caption}}</div>{{/media.caption}}{{/media}}<h4>{{{question}}}</h4><div id="nytmm_qz_container_{{index}}" class="nytmm_qz_container"><div class="nytmm_qz_choices{{#radio_mode}} nytmm_radiomode{{/radio_mode}}">{{{choices_html}}}</div>{{#paper}}<div class="nytmm_paper_mask"></div><div id="nytmm_paper_{{index}}" class="nytmm_paper"></div><div class="nytmm_paper_overlay">{{{overlay_html}}}</div>{{/paper}}</div>{{#response}}<div class="nytmm_qz_response clearfix">{{#response.image}}<img src="{{response.image}}" />{{/response.image}}<span></span>{{{response.text}}}</div>{{/response}}<div class="nytmm_qz_buttons"><div class="nytmm_qz_submit nytmm_button">Check Your Answer(s)</div><div class="nytmm_qz_clear nytmm_button">حذف الاختيارات</div><div class="nytmm_qz_next nytmm_button">Next Question</div></div></div>{{/questions}}',
                    image: '<div class="nytmm_qz_image"><img src="{{source}}" /></div>',
                    video: '<div class="nytmm_qz_video" data-src="{{source}}"></div>',
                    audio: '<div class="nytmm_qz_audio" data-src="{{source}}"></div>',
                    multiple: '{{#choices}}<div class="nytmm_qz_mc clearfix{{#answer}} nytmm_correct{{/answer}}"><div class="nytmm_qz_checkbox"></div><div class="nytmm_qz_mc_choice">{{#image}}<img src="{{image}}" />{{/image}}{{#text}}<p>{{{text}}}</p>{{/text}}</div></div>{{/choices}}',
                    dragdrop: "",
                    linematch: '{{#choices}}<div class="pointA clearfix" data-id="{{pointA.class_name}}">{{#pointA.image}}<img src="{{pointA.image}}" />{{/pointA.image}}<span>{{pointA.text}}</span></div><div class="pointB clearfix"  data-id="{{pointB_alt.class_name}}">{{#pointB_alt.image}}<img src="{{pointB_alt.image}}" />{{/pointB_alt.image}}<span>{{pointB_alt.text}}</span></div><div class="divider"></div>{{/choices}}',
                    linematch_overlay: '{{#choices}}<div class="nytmm_choice_overlay">{{#related}}<div class="nytmm_related"><a href="{{related}}" target="_blank">Related Article</a></div>{{/related}}<div class="nytmm_indiv_clear">حذف الاختيار</div></div>{{/choices}}',
                    shell: '<div class="nytmm_qz"><div class="nytmm_qz_fixie"><div class="nytmm_qz_fixie_content clearfix"><h2>{{title}}</h2><p>Completed <span class="nytmm_qz_x">0</span> of <span class="nytmm_qz_total">{{total}}</span></p></div></div><div class="nytmm_qz_content"></div><div class="nytmm_qz_results"></div></div>',
                    footer: '<h3>Results</h3><div class="nytmm_shareTools"></div><div class="nytmm_qz_score">Score: <span class="nytmm_qz_points">{{score}}</span> of <span class="nytmm_qz_all">{{total}}</div>{{#text}}<div class="nytmm_qz_feedback">{{{text}}}</div>{{/text}}{{#image}}<div class="nytmm_qz_feedback_image"><img src="{{image}}" /></div>{{/image}}{{{freeform}}}'
                },
                share_tools: true,
                shareToolsOptions: {
                    target: ".nytmm_shareTools",
                    theme: "minimal",
                    url: function(g) {
                        return window.location.href
                    },
                    title: function(g) {
                        return window.document.title
                    },
                    description: function(g) {
                        return (g.social ? g.social : "")
                    },
                    thumbnail: function(g) {
                        return (g.image ? g.image : "")
                    },
                    shares: "facebook2|Facebook,twitter|Twitter",
                    adPosition: b
                }
            }, e);
            this.data = f;
            this.init();
            this.formatData()
        };
        a.Quizinator.prototype = {
            init: function() {
                var e = this,
                    d;
                d = Mustache.to_html(e.options.templates.shell, {
                    title: this.data.title,
                    total: this.data.questions.length
                });
                this.$parent.html(d);
                this.$content = this.$parent.find(".nytmm_qz_content");
                this.$fixie = this.$parent.find(".nytmm_qz_fixie");
                this.$footer = this.$parent.find(".nytmm_qz_results").hide();
                this.dashboardHeight = 42;
                this.score = 0;
                this.total = 0
            },
            formatData: function() {
                var e = this,
                    d;
                _.each(this.data.questions, function(h, f) {
                    h.index = f;
                    switch (h.choice_type) {
                        case "multiple":
                            h.answer_array = _.chain(h.choices).map(function(i, j) {
                                return (i.answer) ? j : b
                            }).without(b).value();
                            h.radio_mode = (h.answer_array.length == 1) ? true : false;
                            e.total++;
                            break;
                        case "linematch":
                            _.each(h.choices, function(i, j) {
                                i.pointA.class_name = i.pointB.class_name = "match" + j
                            });
                            var g = _.chain(h.choices).pluck("pointB").shuffle().value();
                            _.each(h.choices, function(i, j) {
                                i.pointB_alt = g[j]
                            });
                            h.paper = true;
                            e.total += h.choices.length;
                            break
                    }
                    if (h.media) {
                        h.media.html = Mustache.to_html(e.options.templates[h.media.type], h.media)
                    }
                    h.choices_html = Mustache.to_html(e.options.templates[h.choice_type], h);
                    if (h.choice_type == "linematch") {
                        h.overlay_html = Mustache.to_html(e.options.templates.linematch_overlay, h)
                    }
                });
                d = Mustache.to_html(e.options.templates.question, this.data);
                this.$content.html(d);
                if (this.data.questions.length > 1) {
                    this.$fixie.fixie({
                        stopAtBottom: true
                    })
                } else {
                    this.$fixie.hide()
                }
                this.bindEvents();
                this.$content.find(".nytmm_qz_question").not(":first").hide()
            },
            bindEvents: function() {
                var d = this;
                this.$questions = this.$content.find(".nytmm_qz_question");
                this.$questions.each(function(m) {
                    var i = c(this).find(".nytmm_qz_choices"),
                        n = c(this).find("#nytmm_qz_container_" + m),
                        g = c(this).find(".nytmm_qz_submit"),
                        h = c(this).find(".nytmm_qz_next"),
                        o = c(this).find(".nytmm_qz_response"),
                        j = c(this).find(".nytmm_qz_clear"),
                        l = c(this).find(".nytmm_indiv_clear"),
                        k = [],
                        e = d.data.questions[m].choice_type;
                    switch (e) {
                        case "multiple":
                            c(this).find(".nytmm_qz_mc").click(function() {
                                if (!i.hasClass("nytmm_answered")) {
                                    if (i.hasClass("nytmm_radiomode")) {
                                        if (c(this).hasClass("nytmm_selected")) {
                                            c(this).removeClass("nytmm_selected")
                                        } else {
                                            i.find(".nytmm_qz_mc").removeClass("nytmm_selected");
                                            c(this).addClass("nytmm_selected")
                                        }
                                    } else {
                                        c(this).toggleClass("nytmm_selected")
                                    }
                                    if (d.checkMultipleChoice(m).num_selected > 0) {
                                        g.fadeIn(200)
                                    }
                                }
                            });
                            break;
                        case "linematch":
                            c("#nytmm_paper_" + m).css({
                                width: n.outerWidth() + "px",
                                height: n.outerHeight() + "px"
                            });
                            c(this).find(".nytmm_paper_mask").css({
                                width: n.outerWidth() + "px",
                                height: n.outerHeight() + "px"
                            });
                            var f = n.drawline({
                                start: ["pointA"],
                                end: ["pointB"],
                                paper: "nytmm_paper_" + m,
                                onCompleteAll: function(p) {
                                    g.fadeIn(200);
                                    j.fadeIn(200);
                                    k = p
                                },
                                onCompleteLine: function(p, q) {
                                    l.eq(q.end.eq).show().click(function() {
                                        f.clearLine(p, q.start.eq, q.end.eq);
                                        c(this).hide()
                                    })
                                }
                            }).data("drawline");
                            break
                    }
                    j.click(function() {
                        j.hide();
                        g.hide();
                        f.clearAll();
                        l.hide()
                    });
                    g.click(function() {
                        if (e == "multiple") {
                            var p = d.checkMultipleChoice(m);
                            if (p.num_incorrect === 0) {
                                o.find("span").html("Correct: ");
                                d.score++
                            } else {
                                o.find("span").html("Incorrect: ")
                            }
                        } else {
                            if (e == "linematch") {
                                d.checkLineMatch(m, k);
                                l.hide()
                            }
                        }
                        o.fadeIn(200);
                        i.addClass("nytmm_answered");
                        c(this).hide();
                        d.updateDashboard(m);
                        if (d.checkIndex(m)) {
                            d.prepFooter()
                        } else {
                            h.fadeIn(200)
                        }
                    });
                    h.click(function() {
                        var r = c(d.$questions[(m + 1)]),
                            p = d.visibleContainersHeight() + 900,
                            q = r.offset().top - d.dashboardHeight;
                        c(this).parent().hide();
                        r.fadeIn(200);
                        d.$content.css("min-height", (p) + "px");
                        c("body").stop().scrollTo(q, 800)
                    })
                })
            },
            checkMultipleChoice: function(e) {
                var f = this,
                    g = {},
                    d = c(this.$questions[e]),
                    h = d.find(".nytmm_qz_mc");
                g.selected = _.chain(h).map(function(j, i) {
                    return (c(j).hasClass("nytmm_selected")) ? i : b
                }).without(b).value();
                g.num_selected = g.selected.length;
                g.num_incorrect = _.chain(g.selected).difference(f.data.questions[e].answer_array).size().value();
                return g
            },
            checkLineMatch: function(g, j) {
                var i = this,
                    d = c(this.$questions[g]),
                    f = d.find(".pointB"),
                    h = d.find(".nytmm_related"),
                    e = i.data.questions[g];
                total = 0;
                _.each(j[g], function(l, k) {
                    if (l.start.el_id == l.end.el_id) {
                        f.eq(l.end.eq).find("span").addClass("nytmm_correct");
                        total++
                    } else {
                        f.eq(l.end.eq).find("span").addClass("nytmm_wrong");
                        f.eq(l.end.eq).append(e.choices[l.start.eq].pointB.text)
                    }
                    h.eq(l.end.eq).find("a").attr("href", e.choices[l.start.eq].related)
                });
                h.show();
                this.score += total
            },
            findRange: function() {
                var d = {},
                    e = this;
                if (this.data.results) {
                    _.each(this.data.results, function(g, f) {
                        if (e.score >= g.range[0] && e.score <= g.range[1]) {
                            d = g
                        }
                    })
                }
                if (this.data.results_freeform) {
                    d.freeform = this.data.results_freeform
                }
                d.score = this.score;
                d.total = this.total;
                return d
            },
            prepFooter: function() {
                var h = this,
                    d, g;
                this.$footer.fadeIn(200);
                c(".nytmm_qz_buttons").hide();
                this.$content.animate({
                    "min-height": (h.visibleContainersHeight()) + "px"
                }, 400, "swing", function() {
                    c("body").scrollTo(h.$footer.offset().top, 400)
                });
                d = this.findRange();
                g = Mustache.to_html(this.options.templates.footer, d);
                this.$footer.html(g);
                if (this.options.share_tools) {
                    var f = c.extend({}, h.options.shareToolsOptions, {
                        url: c.isFunction(h.options.shareToolsOptions.url) ? h.options.shareToolsOptions.url(d) : h.options.shareToolsOptions.url || window.location.href,
                        title: c.isFunction(h.options.shareToolsOptions.title) ? h.options.shareToolsOptions.title(d) : h.options.shareToolsOptions.title || window.document.title,
                        thumbnail: c.isFunction(h.options.shareToolsOptions.thumbnail) ? h.options.shareToolsOptions.thumbnail(d) : h.options.shareToolsOptions.thumbnail || b,
                        description: c.isFunction(h.options.shareToolsOptions.description) ? h.options.shareToolsOptions.description(d) : h.options.shareToolsOptions.description
                    });
                    var e = h.$footer.find(f.target).addClass(f.theme);
                    NYTD.shareTools.init(e, f)
                }
            },
            updateDashboard: function(d) {
                this.$fixie.find(".nytmm_qz_x").html((d + 1))
            },
            checkIndex: function(e) {
                var d = (e < this.data.questions.length - 1) ? false : true;
                return d
            },
            visibleContainersHeight: function() {
                var d = 0;
                c(".nytmm_qz_question").filter(":visible").each(function() {
                    d += c(this).outerHeight(true)
                });
                return d
            }
        }
    }
})(NYTD.NYTMM, jQuery || NYTD.jQuery);
(function(a, c, b) {
    if (a !== b && a.QuizTests === b) {
        a.QuizTests = {
            data: {
                title: "Quiz: Presidential Election History",
                questions: [{
                    question: "جلس التلاميذ مع معلمهم لحفظ سورة الغاشية  .",
                    choice_type: "linematch",
                    choices: [{
                        pointA: {
                            image: "https://media.gettyimages.com/photos/hands-trying-to-catch-soap-bubbles-picture-id888675612",
                            text: "اسم تجريبي"
                        },
                        pointB: {
                            text: "اسم تجريبي"
                        },
                        related: "http://www.nytimes.com/2007/12/16/books/review/Troy-t.html"
                    }, {
                        pointA: {
                            image: "https://media.gettyimages.com/photos/closeup-of-wheat-crops-on-field-picture-id753330953",
                            text: "اسم تجريبي"
                        },
                        pointB: {
                            text: "اسم تجريبي"
                        },
                        related: "http://topics.nytimes.com/top/reference/timestopics/subjects/p/presidential_election_of_1860/index.html"
                    }, {
                        pointA: {
                            image: "https://media.gettyimages.com/photos/raindrops-on-the-green-leaf-closeup-picture-id684834212",
                            text: "اسم تجريبي"
                        },
                        pointB: {
                            text: "اسم تجريبي"
                        },
                        related: "http://query.nytimes.com/mem/archive-free/pdf?res=FA0611FC3B5F1B738DDDAC0994D9415B8685F0D3"
                    }, {
                        pointA: {
                            image: "https://media.gettyimages.com/photos/mt-fuji-over-a-foggy-lake-picture-id844272248",
                            text: "اسم تجريبي"
                        },
                        pointB: {
                            text: "اسم تجريبي"
                        },
                        related: "http://query.nytimes.com/mem/archive-free/pdf?res=F10B15FB385813738DDDAF0894D9415B828DF1D3"
                    }, {
                        pointA: {
                            image: "https://media.gettyimages.com/photos/green-plant-leaves-in-the-sunset-picture-id826970588",
                            text: "اسم تجريبي"
                        },
                        pointB: {
                            text: "اسم تجريبي"
                        },
                        related: "http://graphics8.nytimes.com/images/blogs/learning/pdf/2012/19321104Roosevelt.pdf"
                    }]
                }],
                results_freeform: '<div class="nytmm_qz_feedback">To learn more about each of these memorable elections, read the related Times article for each.</div>'
            },
            init: function() {
                var d = c("#nytmm_quiztests"),
                    e = new a.Quizinator(d, this.data, {
                        share_tools: false
                    })
            }
        };
        c(function() {
            a.QuizTests.init()
        })
    }
})(NYTD.NYTMM, jQuery || NYTD.jQuery);