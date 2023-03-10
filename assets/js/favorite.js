document.getElementById("favorite").addEventListener("click", addToFavorite);

function addToFavorite(e) {
    e.preventDefault();

    const favoriteLink = e.currentTarget;
    const link = favoriteLink.href;
    // Send an HTTP request with fetch to the URI defined in the href
    try {
        fetch(link)
            // Extract the JSON from the response
            .then(res => res.json())
            // Then update the icon
            .then(data => {
                const favoriteIcon = favoriteLink.firstElementChild;
                if (data.isInFavorite) {
                    favoriteIcon.classList.remove("bi-heart");
                    favoriteIcon.classList.add("bi-heart-fill");
                } else {
                    favoriteIcon.classList.remove("bi-heart-fill");
                    favoriteIcon.classList.add("bi-heart");
                }
            });
    } catch (error) {
        alert(error);
    }
}