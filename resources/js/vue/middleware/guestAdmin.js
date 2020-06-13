export default function guest({ next, router }) {
    axios.get("/api/admin/me").then((payload) => {
            return router.push({ name: "admin" });
        })
        .catch((e) => {
            return next();
        });
}