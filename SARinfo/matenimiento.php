<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento</title>
    <!-- Agrega el enlace a Bootstrap CSS y Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Agrega el enlace a SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa; /* Color de fondo */
            padding: 50px;
        }

        .maintenance-module {
            max-width: 400px;
            margin: auto;
            background-color: #ffffff; /* Color de fondo del módulo */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .btn-group .btn {
            margin: 5px;
        }

        .option-container {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="maintenance-module">
        <h3 class="mb-4">Modulo de Edición de Salas</h3>
        <img src="img/mtto.png" alt="Under Construction" class="img-fluid mb-4" width="100px">
        
        <div class="btn-group">
            <button class="btn btn-primary" onclick="showOptions('editar')">Editar Salas <i class="fas fa-edit"></i></button>
            <button class="btn btn-success" onclick="showOptions('crear')">Crear Salas <i class="fas fa-plus"></i></button>
            <button class="btn btn-danger" onclick="showOptions('eliminar')">Eliminar Salas <i class="fas fa-trash"></i></button>
        </div>

        <!-- Opciones de edición -->
        <div class="option-container" id="editar-options">
            <label for="selectSalaEditar">Seleccionar Sala:</label>
            <select id="selectSalaEditar" class="form-control" onchange="obtenerNumeroAlumnos(event)">
                <!-- Opciones de salas (puedes llenarlas desde tu base de datos) -->
            </select>
            <label for="numeroAlumnosEditar">Número de Alumnos:</label>
            <input type="number" id="numeroAlumnosEditar" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            <button class="btn btn-primary mt-3" onclick="guardarCambios()">Guardar Cambios Realizados</button>
        </div>

        <!-- Opciones de creación -->
        <div class="option-container" id="crear-options">
            <label for="numeroSalaCrear">Número de la Sala:</label>
            <input type="number" id="numeroSalaCrear" class="form-control">
            <label for="numeroAlumnosCrear">Número de Alumnos:</label>
            <input type="number" id="numeroAlumnosCrear" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            <button class="btn btn-success mt-3" onclick="guardarNuevaSala()">Guardar</button>
        </div>

        <!-- Opciones de eliminación -->
        <div class="option-container" id="eliminar-options">
            <label for="selectSalaEliminar">Seleccionar Sala:</label>
            <select id="selectSalaEliminar" class="form-control" onchange="obtenerNumeroAlumnos(event)">
                <!-- Opciones de salas (puedes llenarlas desde tu base de datos) -->
            </select>
            <button class="btn btn-danger mt-3" onclick="eliminarSala()">Eliminar</button>
        </div>

<script>
    function showOptions(option) {
        obtenerSalas();

        document.querySelectorAll('.option-container').forEach(optionContainer => {
            optionContainer.style.display = 'none';
        });

        document.getElementById(`${option}-options`).style.display = 'block';

        document.getElementById('numeroAlumnosEditar').value = '';
        document.getElementById('numeroSalaCrear').value = '';
        document.getElementById('numeroAlumnosCrear').value = '';
    }

    function guardarCambios() {
        let data = {
            capacidadSala: document.querySelector("#numeroAlumnosEditar").value,
            salaEditar: document.querySelector("#selectSalaEditar").value
        };

        fetch("../CRUD/actualizarsala.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(res => res.text())
        .then(res => {
            console.log(res);
            if (res.trim() === "OK") {
                alert('Cambios guardados exitosamente.');
            } else {
                alert('Error al actualizar: ' + res);
            }
        })
        .catch(e => {
            alert('Error al actualizar, intente nuevamente.');
            console.log(e);
        });
    }

    function guardarNuevaSala() {
        let data = {
            numeroSala: document.querySelector("#numeroSalaCrear").value,
            capacidadSala: document.querySelector("#numeroAlumnosCrear").value
        };

        fetch("../CRUD/agregarsala.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(res => res.text())
        .then(res => {
            console.log(res);
            if (res.trim() === "OK") {
                alert('Nueva sala guardada exitosamente.');
                document.getElementById('numeroSalaCrear').value = "";
                document.getElementById('numeroAlumnosCrear').value = "";
                obtenerSalas();
            } else {
                alert('Error al guardar: ' + res);
            }
        })
        .catch(e => {
            alert('Error al guardar, intente nuevamente.');
            console.log(e);
        });
    }

    function eliminarSala() {
        const selectedSala = document.getElementById('selectSalaEliminar').value;
        let element = document.getElementById('selectSalaEliminar');

        if (!selectedSala) {
            Swal.fire('Aviso', 'Selecciona una sala.', 'warning');
            return;
        }

        const numeroAlumnos = element[element.selectedIndex].getAttribute("data-max");

        Swal.fire({
            title: `¿Estás seguro de eliminar la Sala ${selectedSala}?`,
            html: `Número de Alumnos: ${numeroAlumnos}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                let data = {
                    salaEliminar: selectedSala
                };

                fetch("../CRUD/eliminarsala.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.text())
                .then(res => {
                    console.log(res);
                    if (res.trim() === "OK") {
                        obtenerSalas();
                        Swal.fire('Eliminado', 'La sala ha sido eliminada.', 'success');
                    } else {
                        Swal.fire('Error', 'La sala no ha sido eliminada: ' + res, 'error');
                    }
                })
                .catch(e => {
                    Swal.fire('Error', 'La sala no ha sido eliminada.', 'error');
                    console.log(e);
                });
            }
        });
    }

    function obtenerSalas() {
        let editarSelect = document.querySelector("#selectSalaEditar");
        let eliminarSelect = document.querySelector("#selectSalaEliminar");

        editarSelect.innerHTML = "";
        eliminarSelect.innerHTML = "";

        let opt1 = document.createElement("option");
        let opt2 = document.createElement("option");
        opt1.text = "-- Selecciona una sala --";
        opt2.text = "-- Selecciona una sala --";
        opt1.value = "";
        opt2.value = "";
        editarSelect.appendChild(opt1);
        eliminarSelect.appendChild(opt2);

        fetch("../CRUD/obtenersalas.php")
        .then(res => res.json())
        .then(data => {
            data.forEach(sala => {
                let option1 = document.createElement("option");
                let option2 = document.createElement("option");

                option1.text = `Sala ${sala.idsala}`;
                option2.text = `Sala ${sala.idsala}`;
                option1.value = sala.idsala;
                option2.value = sala.idsala;

                option1.setAttribute("data-max", sala.capacidad);
                option2.setAttribute("data-max", sala.capacidad);

                editarSelect.appendChild(option1);
                eliminarSelect.appendChild(option2);
            });
        })
        .catch(e => {
            console.log(e);
        });
    }

    function obtenerNumeroAlumnos(event) {
        let input = document.querySelector("#numeroAlumnosEditar");
        let id = event.target.value;

        if (!id) {
            input.value = "";
            return;
        }

        let data = {
            idsala: id
        };

        fetch("../CRUD/obteneralumnos.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(data => {
            input.value = data.capacidad;
        })
        .catch(e => {
            console.log(e);
        });
    }
</script>

    </div>
</body>
</html>



