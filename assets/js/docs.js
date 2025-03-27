document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".open-modal").forEach(button => {
        button.addEventListener("click", async function () {
            const index = parseInt(this.dataset.id, 10);

            try {
                const response = await fetch("/api/personnages");
                const jsonData = await response.json();

                if (!jsonData[index]) {
                    console.error("Aucune donnée trouvée pour l'index :", index);
                    return;
                }

                const data = jsonData[index];

                // Mise à jour du modal
                document.getElementById("modalImage").src = this.getAttribute("data-image");
                document.getElementById("modalImage").alt = `Image de ${data.nom}`;
                document.getElementById("modalPDF").href = this.getAttribute("data-pdf");
                document.getElementById("modalCName").textContent = data.nom;

                let categories = `<b>Catégorie${data.categorie.length > 1 ? 's' : ''} -</b> `

                for (const elt of data.categorie) {
                    categories += `<a class="text-reset search-link" href="/docs?search=${elt}">${elt}</a>, `;
                }

                document.getElementById("modalCategories").innerHTML = categories.slice(0, -2);

                let auteurs = `<b>Auteur${data.auteur.length > 1 ? 's' : ''} -</b> `

                for (const elt of data.auteur) {
                    auteurs += `<a class="text-reset search-link" href="/docs?search=${elt}">${elt}</a>, `;
                }

                document.getElementById("modalAuthors").innerHTML = auteurs.slice(0, -2);

            } catch (error) {
                console.error("Erreur de chargement du JSON :", error);
            }
        });
    });
});