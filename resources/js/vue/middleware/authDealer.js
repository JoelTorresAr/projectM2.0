export default function auth({ next, router }) {
    axios.get("/api/dealer/me").then((payload) => {
            return next();
        })
        .catch((e) => {
            return router.push({ name: "authenticatedealer" });
        });
}