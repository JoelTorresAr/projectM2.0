export default function guest({ next, router }) {
    axios.get("/api/dealer/me").then((payload) => {
            return router.push({ name: "dealer" });
        })
        .catch((e) => {
            return next();
        });
}