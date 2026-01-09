let validate = (arr) => {
    let err_count = 0;
    if (arr.length) {
        arr.forEach(element => {
            if ($(`#${element}`).val() == '') {
                $(`#${element}`).removeClass('input-success');
                $(`#${element}`).addClass('input-error');
                err_count++;
            } else {
                $(`#${element}`).removeClass('input-error');
                $(`#${element}`).addClass('input-success');
            }
        });
    }
    return err_count;
}

let clearValues = (arr) => {
    if (arr.length) {
        arr.forEach(element => {
            $(`#${element}`).val('');
            $(`#${element}`).removeClass('input-error');
            $(`#${element}`).removeClass('input-success');
        });
    }
}