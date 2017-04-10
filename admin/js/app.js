var User, Dao, Crud, Files;

Files = {
        init: function() {
            var _self = this;
            _self.addEventListeners();
        },
        addEventListeners: function() {
            var _self = this;
            $("a.onClickUnlink").click(function(e) { _self.remove(e); });
            $("a.onClickFileRemove").click(function(e) { _self.remove(e); });
        },
        remove: function(e) {
            var el;
            if (!confirm("Favor de confirmar la eliminación del archivo")) { return; }
            if (e.target.tagName.toLowerCase() == "i") { el = $(e.target).parent(); } else { el = $(e.target); }
            var path = $(el).data("path");
            var callback = $(el).data("callback");
            Dao.execute("files", {
                    exec: "delete",
                    data: { path: path }
                },
                function(r) {
                    if (r.status == 202) {

                        // location.reload();
                        window[callback]();
                    } else if (r.status == 500) {
                        alert("Hubo un Error en la petición");
                    }
                });
        }
    }
    /* DATAGRID */
Datagrid = {
    init: function() {
        var _self = this;
        this.result = null;
        _self.addEventListeners();
    },
    addEventListeners: function() {
        var _self = this;
    },

    /* params: receive object with configuration parameters. */
    getTable: function(p) {
        _self = this;
        var table = new Object();
        var buffer = '';

        table.tbody = $("#" + p.table.id + " > tbody");
        var template = table.tbody.html();
        Dao.execute(p.table.src, {
                exec: p.table.exec,
                data: p
            },
            function(r) {
                _self.result = r;
                if (r.status == 202) {
                    data = r.tbody;
                    for (var i = 0; i < data.length; i++) { buffer += _self.map(template, data[i]); }
                    table.tbody.empty().append(buffer);
                    //pagination
                    var pages_buff = '<li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>';
                    var pages = r.pages;

                    for (var i = 0; i < pages; i++) {
                        var classes = '';
                        if (i == 0) { classes += 'active '; }
                        classes += 'waves-effect';
                        pages_buff += '<li class="' + classes + ' yellow darken-2"><a href="#!">' + (i + 1) + '</a></li>';
                    }
                    pages_buff += '<li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>';
                    $("ul.pagination").html(pages_buff);
                } else if (r.status == 404) {}
            }
        );
    },
    /* eof */

    /**/
    map: function(buffer, obj) {
        var str = buffer;
        for (var key in obj) { str = str.replace(new RegExp("{" + key + "}", "gi"), obj[key].toString()); }
        return str;
    },
    /* eof */
}

/* GLOBAL CRUD */
Crud = {
    init: function() {
        var _self = this;
        _self.addEventListeners();
    },
    addEventListeners: function() {
        var _self = this;
        $(document).on("click", "a.onSave", function(e) { _self.save(e); });
        $(document).on("click", "a.onClickDelete", function(e) { _self.delete(e); });
        $(document).on("click", "a.onClickApprove", function(e) { _self.approve(e); });
        $(document).on("click", "a.onClickUnDelete", function(e) { _self.undelete(e); });
        $(document).on("click", "a.onView", function(e) { _self.get(e); });
    },
    save: function(e) {
        _self = this;
        var formData = Dao.toObject($($(e.target).data("form")).serializeArray());
        var action = $(e.target).data("action");
        var src = $(e.target).data("src");
        if (!_self.validate($(e.target).data("form"))) { return false; };
        if(src == 'admin'){var permisos = $('#permisos').val(); formData.permisos = permisos;}
        Dao.execute($(e.target).data("src"), {
                exec: action,
                data: formData
            },
            function(r) {
                if (r.status == 202) {
                    if (src == 'servicio') {
                        upload(r.id);
                    }
                    swal({
                        title: "",
                        text: "Información guardada con éxito.",
                        type: "success",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#2C8BEB"
                    }, function(isConfirm) { if (isConfirm) { location.reload(); } });
                } else if (r.status == 409) {
                    alert("Hubo un Error");
                } else if (r.status == 204) {
                    console.log(formData.id);
                    $('.row' + formData.id).hide('slow');
                }
            });
    },
    delete: function(e) {
        _self = this;
        var el;
        swal({
            title: "",
            text: "Por favor confirme la eliminación del registro",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Eliminar",
            closeOnConfirm: false
        }, function() {
            swal("Eliminado", "El registro se ha eliminado correctamente.", "success");
            // swal("Deleted!", "Se borró el registro.", "success");
            if (e.target.tagName.toLowerCase() == "i") { el = $(e.target).parent(); } else { el = $(e.target); }
            var id = el.data("id");
            var src = el.data("src");
            Dao.execute(src, {
                    exec: "delete",
                    data: { id: id }
                },
                function(r) {
                    if (r.status == 202) {
                        $('.row' + id).hide('slow');
                    } else if (r.status == 500) {
                        swal("Error!", "Hubo un error en la petición.", "error");
                    }
                });

        });
    },
    approve: function(e) {
        _self = this;
        var el;
        swal({
            title: "",
            text: "Por favor confirme la aprobación",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aprobar",
            closeOnConfirm: false
        }, function() {
            swal("Aprobado", "Aprobado correctamente.", "success");
            // swal("Deleted!", "Se borró el registro.", "success");
            if (e.target.tagName.toLowerCase() == "i") { el = $(e.target).parent(); } else { el = $(e.target); }
            var id = el.data("id");
            var src = el.data("src");
            Dao.execute(src, {
                    exec: "approve",
                    data: { id: id }
                },
                function(r) {
                    if (r.status == 202) {
                        $('.row' + id).hide('slow');
                    } else if (r.status == 500) {
                        swal("Error!", "Hubo un error en la petición.", "error");
                    }
                });

        });
    },
    undelete: function(e) {
        _self = this;
        var el;
        if (!confirm("Favor de confirmar la actualización del estatus.")) { return; }
        if (e.target.tagName.toLowerCase() == "i") { el = $(e.target).parent(); } else { el = $(e.target); }
        var id = el.data("id");
        var src = el.parents("table").data("src");
        Dao.execute(src, {
                exec: "undelete",
                data: { id: id }
            },
            function(r) {
                if (r.status == 202) {
                    alert("El registro ha sido activado nuevamente");
                    location.reload();
                } else if (r.status == 500) {
                    alert("Hubo un Error en la petición");
                }
            });
    },
    validate: function(form) {
        var flag = true;
        $(form + " .isRequired").each(function(index) {
            if ($(this).val() == "" || $(this).val() == "NULL" || $(this).val() == null) {
                $(this).addClass("invalid");
                flag = false;
            }
        });
        return flag;
    },
    get: function(e) {
        _self = this;
        var el;
        if (e.target.tagName.toLowerCase() == "i") { el = $(e.target).parent(); } else { el = $(e.target); }
        var table = el.parents("table");
        var data = { id: el.data("id") };
        var src = $(table).data("src");
        var form = $(table).data("form");
        $(form + " a.onSave").data("action", "update");
        Dao.execute(src, {
                exec: "get",
                data: data
            },
            function(r) {
                if (r.status == 202) {
                    _self.mapForm(form, r.data);
                    $('#modal_' + src).openModal();
                } else if (r.status == 404) {}
            });
    },
    mapForm: function(form, obj) {
        for (var key in obj) {
            var el = $(form).find("#" + key);
            if (el.length == 1) {
                el.val(obj[key]);
            }
            str = str.replace(new RegExp("{" + key + "}", "gi"), obj[key].toString());
        }
    },
}



/* DATA ACCESS OBJECT*/
Dao = {
    init: function() {
        var _self = this;
    },
    toObject: function(form) {
        var data = {};
        $.each(form, function(key, element) {
            if (element.name.indexOf("[]") >= 0) {
                var aux = data[element.name];
                if (aux == null) { aux = ""; }
                data[element.name] = aux + element.value + "|";
            } else {
                data[element.name] = element.value;
            }
        });
        return data;
    },
    execute: function(ctrl, data, callback) {
        $.ajax({
            type: "POST",
            url: '_ctrl/ctrl.' + ctrl + '.php',
            data: data,
            dataType: "json",
            success: function(r) { callback(r); },
            error: function(r) { console.log(r); }
        });
    }
}


User = {
    init: function() {
        var _self = this;
        _self.addEventListeners();
    },
    addEventListeners: function() {
        var _self = this;
        $(document).on("click", "a.onClickRegister", function(e) { _self.register(); });
        $(document).on("click", "button.onClickLogin", function(e) { _self.login(); });
        $(document).on("click", "button.onClickLoginClient", function(e) { _self.login_client(); });
        $(document).on("click", "a.onClickRecover", function(e) { _self.recover(); });

        $(document).on("click", "a.onClickSaveChecklist", function(e) {
            alert(123);
            _self.save_checklist();
        });

        $(document).on("click", "a.onClickRemovePoints", function(e) { _self.user_rem_points($(this).data("id")); });

    },
    save_checklist: function(e) {
        alert(123);
        var checklist = Dao.toObject($("#frmChekList").serializeArray());
        console.log(checklist);
        return;
        Dao.execute("usuario", {
                exec: "save",
                data: user
            },
            function(r) {
                if (r.status == 202) {
                    $("#frmUserRegister")[0].reset();
                    alert("User is registered.");
                } else if (r.status == 409) {
                    alert("User already exists");
                }
            });
    },
    user_rem_points: function(uid) {
        if (!confirm("Favor de confirmar si desear realizar el corte de -50 pts.")) { return; }
        Dao.execute("usuario", {
                exec: "user_rem_points",
                data: { uid: uid }
            },
            function(r) {
                if (r.status == 202) {
                    alert("Se ha realizado el corte de -50 pts.");
                    location.reload();
                } else if (r.status == 409) {
                    //alert("User already exists"); 
                }
            });
    },
    register: function(e) {
        var user = Dao.toObject($("#frmUserRegister").serializeArray());
        Dao.execute("usuario", {
                exec: "save",
                data: user
            },
            function(r) {
                if (r.status == 202) {
                    $("#frmUserRegister")[0].reset();
                    alert("User is registered.");
                } else if (r.status == 409) {
                    alert("User already exists");
                }
            });
    },
    login: function() {
        var user = Dao.toObject($("#frmUserLogin").serializeArray());
        Dao.execute("usuario", {
                exec: "auth",
                data: user
            },
            function(r) {
                if (r.status == 202) {
                    localStorage.setItem("isLogged", 1);
                    localStorage.setItem("uid", r.uid);
                    localStorage.setItem("t", "a");
                    location.href = 'process.html?id=' + r.uid;
                } else if (r.status == 404) {
                    localStorage.setItem("isLogged", 0);
                    localStorage.setItem("uid", null);
                    alert("No existe el usuario");
                }
            });
    },
    login_client: function() {
        var user = Dao.toObject($("#frmClientLogin").serializeArray());
        Dao.execute("caso", {
                exec: "auth_codigo",
                data: user
            },
            function(r) {
                if (r.status == 202) {
                    localStorage.setItem("isLogged", 1);
                    localStorage.setItem("cid", r.id);
                    localStorage.setItem("uid", 0);
                    localStorage.setItem("t", "c");
                    location.href = 'process.html?id=' + r.id;
                } else if (r.status == 404) {
                    localStorage.setItem("isLogged", 0);
                    localStorage.setItem("cid", 0);
                    localStorage.setItem("cid", null);
                    alert("No existe el CODE ID ingresado.");
                }
            });
    },
    recover: function() {
        var user = Dao.toObject($("#frmUserRecover").serializeArray());
        Dao.execute("usuario", {
                exec: "recover",
                data: user
            },
            function(r) {
                if (r.status == 202) {
                    $("#frmUserRecover")[0].reset();
                    alert("Se envia correo...");
                } else if (r.status == 404) {
                    alert("No existe el usuario");
                }
            });
    },

}



$(window).load(function() {
    Crud.init();
    Files.init();
});


/* UTILITIES */
function isValidEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function _GET() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
        vars[key] = value;
    });
    return vars;
}