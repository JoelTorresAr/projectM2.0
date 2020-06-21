export default function can({ next, router }, value) {
    var jsPermissions = localStorage.getItem("permissions")
    var permissions = JSON.parse(jsPermissions);
    if (!Array.isArray(permissions)) {
        return router.push({ name: "unauthorized" });
    }
    if (value.includes('|')) {
        value.split('|').forEach(function(item) {
            if (permissions.includes(item.trim())) {
                return next();
            }
        });
    } else if (value.includes('&')) {
        return next();
        value.split('&').forEach(function(item) {
            if (!permissions.includes(item.trim())) {
                return router.push({ name: "unauthorized" });
            }
        });
    } else {
        if (permissions.includes(value.trim())) {
            return next();
        } else {
            return router.push({ name: "unauthorized" });
        }
    }
}