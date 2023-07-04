// table loaded data search .....
let searchKewoard = document.getElementById('searchKewoard');
if (searchKewoard) {
    searchKewoard.addEventListener('keyup',
            function () {
                serarchData(searchKewoard.value.trim());
            });
}

// Insert json data ....
let insertAllData = document.getElementById('insertAllData');
if (insertAllData) {
    insertAllData.addEventListener('click',
            function () {
                actionRequest("insert");
            });
}

// delete confirmation
let deleteAllData = document.getElementById('deleteAllData');
if (deleteAllData) {
    deleteAllData.addEventListener('click',
            function () {
                actionRequest("delete");
            });
}