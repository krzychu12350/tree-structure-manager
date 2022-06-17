import './bootstrap';

const url = '/api/categories';

let getListItems = dataset => {

    return dataset.map(item => {
        let nested = getTreeStructureTemplate(item.children || [])

        if (item.children.length !== 0) {
            return `<li class="parent_li hasItems"><span class="item"
                data-id="${item.id}" data-name="${item.name}"
                data-parent-id="${item.parent_id}" title="Collapse this branch">
                ${item.name}</span><i class="fa fa-sort m-1 cursor-pointer sort-icon"></i>
                ${nested}</li>`
        }

        return `<li><span class="item" data-id="${item.id}" data-name="${item.name}"
                    data-parent-id="${item.parent_id}">
                    ${item.name}</span></li>${nested}`
    }).join('')
}

let getTreeStructureTemplate = dataset => {
    if (dataset.length) {
        return `<ul class="sublist">${getListItems(dataset)}</ul>`
    } else {
        return ''
    }
};

function nodesCollapse() {
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').dblclick(function (e) {
        let children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i');
        }
        e.stopPropagation();
    });
}

function populateParentSelectOptions() {
    let allPossibleParent = $(".item").map(function () {
        return {
            id: $(this).data("id"),
            name: $(this).data("name")
        };
    }).get();

    $.each(allPossibleParent, function (key, value) {
        let optionExists = $(".parent-select option[value='" + value.id + "']").length > 0;
        if (!optionExists) {
            $('.parent-select').append(`<option value="${value.id}">${value.name}</option>`);
        }
    });
}

const fetchTreeData = function () {
    fetch(url, {
        method: "get"
    })
        .then(async (response) => {
            return response.json();
        })
        .then((data) => {
            let ar = [];
            for (let item in data) {
                ar.push(data[item]);
            }
            const div = document.querySelector('.tree')
            div.innerHTML = getTreeStructureTemplate(ar)

            nodesCollapse()
            populateParentSelectOptions()
        })
        .catch(function (error) {
            console.log(error);
        });
}

document.addEventListener('DOMContentLoaded', function () {
    fetchTreeData()
})

$(".sort-icon").click(function () {
    alert("The icon was clicked.");
});

const addCategoryForm = document.querySelector('#addCategoryForm')
const addCategory = function (e) {
    let categoryName = document.querySelector('#inputNameAdd').value
    let parentNameId = document.querySelector('#selectParentAdd').value

    const newCategory = {
        category_name: categoryName,
        parent_id: parentNameId,
    }

    fetch(url, {
        method: 'POST',
        mode: 'cors',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(newCategory)
    })
        .then(res => res.json())
        .then(res => {
            alert(res['message']);
        })
    fetchTreeData()
    populateParentSelectOptions()
    e.preventDefault()
}
addCategoryForm.addEventListener('submit', addCategory)

const editCategoryForm = document.querySelector('#editCategoryForm')
const editCategory = function (e) {
    let categoryId = document.querySelector('#inputIdCategoryEdit').value
    let categoryName = document.querySelector('#inputNameEdit').value
    let parentNameId = document.querySelector('#selectParentEdit').value

    const existingCategory = {
        id_category: categoryId,
        category_name: categoryName,
        parent_id: parentNameId,
    }

    fetch(url + '/' + categoryId, {
        method: 'PUT',
        mode: 'cors',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(existingCategory)
    })
        .then(res => res.json())
        .then(res => {
            alert(res['message']);
        })
    fetchTreeData()
    populateParentSelectOptions()
    e.preventDefault()
}
editCategoryForm.addEventListener('submit', editCategory)

const deleteCategoryForm = document.querySelector('#deleteCategoryForm')
const deleteCategory = function (e) {
    let categoryId = document.querySelector('#inputIdCategoryDelete').value

    const existingCategoryToDelete = {
        id_category: categoryId
    }

    fetch(url + '/' + categoryId, {
        method: 'DELETE',
        mode: 'cors',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(existingCategoryToDelete)
    })
        .then(res => res.json())
        .then(res => {
            alert(res['message']);
        })
    fetchTreeData()
    populateParentSelectOptions()
    e.preventDefault()
}
deleteCategoryForm.addEventListener('submit', deleteCategory)

$(document).on('click', '.item', function () {
    if ($("#add-tab").hasClass("active")) {
        $("#selectParentAdd").val($(this).data("id"));
    }
    if ($("#edit-tab").hasClass("active")) {
        $("#inputIdCategoryEdit").val($(this).data("id"));
        $("#inputNameEdit").val($(this).data("name"));
        $("#selectParentEdit").val($(this).data("parent-id"));
    }
    if ($("#delete-tab").hasClass("active")) {
        $("#inputIdCategoryDelete").val($(this).data("id"));
        $("#readonlyInputNameForDelete").val($(this).data("name"));
        let id = $(this).data("parent-id");
        $("#readonlyInputParentForDelete").val($("[data-id='" + $(this).data("parent-id") + "']").data('name'));
    }
});

