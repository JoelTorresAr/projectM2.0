export default function guest({ next, router }) {
    axios.get("/api/user/me").then((payload) => {
            return window.history.length > 1 ? this.$router.go(-1) : this.$router.go({ name: "indexstore" })
        })
        .catch((e) => {
            return next();
        });
}