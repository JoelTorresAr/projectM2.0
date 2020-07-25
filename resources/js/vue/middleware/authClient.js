export default function auth({ next, router }) {
    axios.get("/api/user/me").then((payload) => {
            return next();
        })
        .catch((e) => {
            return router.push({ name: "authenticateclient" });
        });
}