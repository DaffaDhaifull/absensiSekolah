window.api = {
    get: async function(url) {
        const res = await fetch(url)
        const json = await res.json()
        return json
    }
}

window.logout = () => {
    const formLogout = document.getElementById("formLogout")
    if (confirm("Apakah yakin ingin Log Out?")) { formLogout.submit() }
  }