@extends('layouts.admin')
@section('title', 'Comunicados')
@section('library')
    @include('cdn.datatables-head')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <style>
        .cursor-pointer {
            cursor: help;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list"></i> Lista de comunicados
                </div>

                <div class="card-body">
                    <div class="">
                        <table class="table-bordered table-striped display nowrap compact" id="datatable-Comunicados"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Clientes:</th>
                                    <th>Correos:</th>
                                    <th>Usuario que notifica:</th>
                                    <th>Fecha de envió:</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @can('CREAR_COMUNICADOS')
            <div class="col-12 col-xl-6">
                <form action="{{ route('admin.comunicados.store') }}" method="POST" enctype="multipart/form-data"
                    id="crear-comunicado">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-plus-circle"></i> Nuevo Comunicado
                        </div>

                        <div class="card-body row">
                            <div class="col-12 col-md-12">
                                <div class="form-floating mb-3">
                                    <div class="row d-flex justify-content-between ">
                                        <div class="col-12">
                                            <label class="fw-normal">
                                                Seleccionar uno o varios clientes: <b class="text-danger">*</b>
                                            </label>
                                        </div>
                                        <div class="col">
                                            <div class="btn-group mb-2">
                                                <button id="selectAllButton4" type="button"
                                                    class="btn btn-outline-info btn-xs  btn-radius px-4 me-2"
                                                    style="border-radius: 5px">Seleccionar Todo</button>
                                                <button id="deselectAllButton4" type="button"
                                                    class="btn btn-outline-info btn-xs btn-radius px-4 "
                                                    style="border-radius: 5px">Deseleccionar Todo</button>
                                            </div>
                                        </div>
                                    </div>
                                    <select id="multiple-checkboxes4" multiple="multiple"
                                        class="form-select custom-select-border w-100 py-4" name="clientes[]" data-dropup="true"
                                        data-container="body" required>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">
                                                {{ $cliente->razon_social }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="clientes" class="text-danger"></span>
                                </div>
                            </div>

                            <div class=" col-xl-12 mb-3">
                                <label for="comunicado" class="fw-normal">Comunicado <b class="text-danger">*</b></label>
                                <textarea id="comunicado" name="comunicado" rows="1" class="form-control" style="height: 150px"></textarea>
                                <span id="error-comunicado" class="text-danger"></span>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="input-group mb-3">
                                    <label class="input-group-text bg-transparent" for="documento_uno"><i
                                            class="fas fa-file-upload"></i></label>
                                    <input type="file" id="documento_uno" name="documento_uno" class="form-control" />
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="input-group mb-3">
                                    <label class="input-group-text bg-transparent" for="documento_dos"><i
                                            class="fas fa-file-upload"></i></label>
                                    <input type="file" id="documento_dos" name="documento_dos" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group text-end">
                                <button class="btn btn-save btn-radius px-4" type="submit" id="btn-guardar-comunicado">
                                    <i class="fa-solid fa-paper-plane"></i> Enviar
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        @endcan
    </div>




@endsection


@section('scripts')
    @parent
    <script>
        let table;

        document.addEventListener("DOMContentLoaded", function() {
            table = new DataTable('#datatable-Comunicados', {
                language: {
                    url: "{{ asset('/js/datatable/Spanish.json') }}",
                },
                layout: {
                    topStart: ['search'],
                    topEnd: ['pageLength'],
                    bottomEnd: {
                        paging: {
                            type: 'simple_numbers',
                            numbers: 5,
                        }
                    }
                },
                ordering: true,
                //ordenar por la columna 0 de forma ascendente
                order: [
                    [0, 'desc']
                ],
                responsive: true,
                // columnDefs: [

                // ],
                // searching: true,
                pageLength: 10,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.comunicados.index') }}",
                dataType: 'json',
                type: "POST",
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
                    },
                    {
                        data: 'clientes',
                        name: 'clientes',
                        className: 'cursor-pointer',
                    },
                    {
                        data: 'correos_enviados',
                        name: 'correos_enviados',
                    },
                    {
                        data: 'user.nombres',
                        name: 'user.nombres',
                        render: function(data, type, row) {
                            return row.user ? row.user.nombres + ' ' + row.user.apellidos : '';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return data ? moment(data).format('DD/MM/YYYY h:mm a') : '';
                        }
                    },
                    {
                        data: 'id',
                        name: 'ver',
                        render: function(data, type, row) {
                            let buttonInfo =
                                `<a class="btn-ver px-2 py-0" href="{{ url('admin/comunicados') }}/${data}" title="Ver más información">
                                    <i class="fas fa-eye"></i>
                                </a>`;

                            return buttonInfo;
                        },
                    }
                ],
                // select: {
                //     style: 'multi',
                //     className: 'selected-row',
                // },
                initComplete: function() {

                } //intiComplete

            });

        });

        $(document).ready(function() {
            // Inicializar el campo select múltiple con Select2 de las otras entidades
            $("#multiple-checkboxes4").select2({
                dropdownCssClass: 'custom-dropdown', // Clase CSS personalizada para el menú desplegable
                containerCssClass: 'custom-container', // Clase CSS personalizada para el contenedor del select
                closeOnSelect: false // Evitar que se cierre al seleccionar
            });
            // Agregar funcionalidad al botón "Seleccionar Todo"
            $("#selectAllButton4").on("click", function() {
                $("#multiple-checkboxes4").find("option").prop("selected", true);
                $("#multiple-checkboxes4").trigger(
                    "change"); // Actualizar el select2 después de la selección
            });
            // Agregar funcionalidad al botón "Deseleccionar Todo"
            $("#deselectAllButton4").on("click", function() {
                $("#multiple-checkboxes4").find("option").prop("selected", false);
                $("#multiple-checkboxes4").trigger(
                    "change"); // Actualizar el select2 después de la desselección
            });

        });

        let editor;

        ClassicEditor
            .create(document.querySelector('#comunicado'), {
                toolbar: {
                    items: [
                        'bold', 'italic', '|', 'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'undo', 'redo',
                    ],
                    shouldNotGroupWhenFull: true
                },
                link: {
                    decorators: {
                        openInNewTab: {
                            mode: 'manual',
                            label: 'Abre en una ventana nueva',
                            defaultValue: true,
                            attributes: {
                                target: '_blank',
                                rel: 'noopener noreferrer'
                            }
                        }
                    }
                }
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });


        $('#btn-guardar-comunicado').click(function(event) {
            event.preventDefault(); // Evitar el envío normal del formulario
            const formulario = document.getElementById('crear-comunicado');

            var clientes = $('#multiple-checkboxes4 option:selected').map(function() {
                return $(this).text().trim();
            }).get();
            var comunicado = editor.getData();
            let mensaje = '<strong>Clientes seleccionados:</strong> <br> ' + clientes + '<br><br>';
            mensaje += '<strong>Comunicado:</strong> ' + comunicado;

            Swal.fire({
                title: "¿Estás seguro de enviar esta información al comunicado?",
                html: `
                    <div style="max-height: 300px; overflow-y: auto;"> ${mensaje} </div>
                    `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#69c34e",
                scrollbarPadding: false, // Evita que SweetAlert manipule el padding de la página
                heightAuto: false,
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {

                    var formData = new FormData(formulario); // Crear un objeto FormData
                    // Reemplazar el valor del campo 'comunicado' en el FormData
                    formData.set('comunicado', comunicado);

                    Swal.fire({
                        title: 'Enviando correo...',
                        icon: 'info',
                        showConfirmButton: false,
                        position: 'top',
                        toast: true,
                        timer: 1500,
                        didOpen: () => {
                            // Elevar el z-index para que esté por encima del modal Bootstrap
                            const swalContainer = Swal.getPopup().parentNode;
                            swalContainer.style.zIndex = '20000';
                        }
                    });

                    // Enviar los datos usando fetch
                    $.ajax({
                        url: $(this).attr('action'), // URL del endpoint
                        type: 'POST',
                        data: formData,
                        contentType: false, // No establecer el tipo de contenido
                        processData: false, // No procesar los datos
                        success: function(response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }

                            });
                            Toast.fire({
                                icon: "success",
                                title: "Comunicado enviado exitosamente."
                            });

                            // Reiniciar el formulario después del envío exitoso
                            formulario.reset();
                            $('#multiple-checkboxes4').val(null).trigger('change');
                            // Limpiar el editor CKEditor
                            editor.setData('');
                            // Recargar la tabla DataTable
                            table.ajax.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                            $('#clientes').text('');
                            $('#error-comunicado').text('');

                            if (jqXHR.status === 422) { // Verifica si es un error de validación
                                const errors = jqXHR.responseJSON.errors; // Captura los errores

                                // Muestra el mensaje de error en el elemento correspondiente
                                if (errors.clientes) {
                                    $('#clientes').text(errors.clientes[0]);
                                }
                                if (errors.comunicado) {
                                    $('#error-comunicado').text(errors.comunicado[0]);
                                }
                            }

                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }

                            });
                            Toast.fire({
                                icon: "error",
                                title: jqXHR.responseJSON.message ||
                                    "Error al enviar el comunicado."
                            });

                            console.error('Error:', textStatus, errorThrown);
                        }
                    });
                }
            });
        });
    </script>
@endsection
