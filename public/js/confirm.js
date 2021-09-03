const deleteModule = (() => {
    return {
        showDialog: (event) => {
            // preventDefaultでフォームの動き（submitなど）を一旦止める
            event.preventDefault();
            if (window.confirm('Are you sure you want to delete this note?')) {
                // deleteがOKならば、フォーム動作再開
                document.getElementById('delete-form').submit();
            } else {
                alert('Canceled');
            }
        }
    }
})();

const popUpModule = (() => {
    return {
        showPopUp: (event) => {
            // preventDefaultでフォームの動き（submitなど）を一旦止める
            event.preventDefault();
            document.getElementById('popup').style.display = 'flex';
        },
        clickDelete: () => {
            document.deleteForm.submit();
            document.getElementById('popup').style.display = 'none';
        },
        clickCancel: () => {
            document.getElementById('popup').style.display = 'none';
        },
    }
})();