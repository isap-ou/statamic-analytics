var a=/\s/;function t(e){for(var r=e.length;r--&&a.test(e.charAt(r)););return r}var c=/^\s+/;function n(e){return e&&e.slice(0,t(e)+1).replace(c,"")}export{n as b};
