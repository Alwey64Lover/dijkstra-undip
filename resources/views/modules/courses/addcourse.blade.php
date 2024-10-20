<meta name="csrf-token" content="{{ csrf_token() }}">
<form id="add-course-form">
    <label for="course-name">Nama Mata Kuliah:</label>
    <input type="text" id="course-name" name="course_name" required><br><br>

    <label for="course-class">Kelas:</label>
    <input type="text" id="course-class" name="course_class" required><br><br>

    <label for="start-time">Waktu Mulai:</label>
    <input type="time" id="start-time" name="start_time" required><br><br>

    <label for="end-time">Waktu Selesai:</label>
    <input type="time" id="end-time" name="end_time" required><br><br>

    <button type="submit">Simpan</button>
    <button type="button" id="cancel-button">Batal</button>
</form>

<script>
    document.getElementById('cancel-button').addEventListener('click', function(event){
        document.getElementById('form-container').style.display = 'none';
        document.getElementById('dashboard-container').style.display = 'block';
    });
</script>
