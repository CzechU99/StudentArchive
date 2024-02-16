function validateForm() {
    var password1 = document.getElementById("rej_haslo_input").value;
    var password2 = document.getElementById("rej_haslo2_input").value;

    if (password1 !== password2) {
        alert("Hasła nie są takie same!!!");
        return false; // Zatrzymuje domyślne zachowanie przesyłania formularza
    }
    return true; // Pozwala na przesłanie formularza, jeśli walidacja jest poprawna
}

