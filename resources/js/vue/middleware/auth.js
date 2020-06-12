export default function auth({ next, router }) {
    axios.get("/api/admin/me").then((payload) => {
            return next();
        })
        .catch((e) => {
            return router.push({ name: "authenticate" });
        });
}