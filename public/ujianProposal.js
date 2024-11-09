$(document).ready(function () {
    // Fungsi upload file
    $("#uploadForm").on("submit", function (e) {
        e.preventDefault();
        var fileInput = $("#fileInput")[0];
        
        if (fileInput.files.length === 0) {
            $("#uploadStatus").html('<span class="text-danger">Pilih file sebelum mengunggah.</span>');
            return;
        }
        
        var file = fileInput.files[0];
        
        // Validasi ukuran file
        if (file.size > 5242880) { // 5MB in bytes
            $("#uploadStatus").html('<span class="text-danger">File terlalu besar! Maksimal 5MB.</span>');
            return;
        }
        
        // Validasi format file
        if (file.type !== "application/pdf") {
            $("#uploadStatus").html('<span class="text-danger">Hanya file PDF yang diizinkan.</span>');
            return;
        }

        // Simulasi upload berhasil
        $("#uploadStatus").html('<span class="text-success">File berhasil diunggah!</span>');
    });
});
