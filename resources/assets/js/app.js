
const form = document.querySelector('#form');

form.addEventListener("submit", (e) => {
    e.preventDefault()

    const email = form.querySelector('input').value
    
    $.ajax({
        type: "post",
        url: "/back-end/ajax",
        dataType: "json",
        data: {
            module: 'Searches',
            action: 'getRegister',
            credential: email
        },
        success: function (response) {
            Swal.fire({
                position: 'top-right',
                icon: 'success',
                title: 'Aqui está o seu histórico de consultas!',
                showConfirmButton: false,
                timer: 1500
            })

            var obj = response.response_data.list
            
            if (!obj) {
                Swal.fire({
                    position: 'top-right',
                    icon: 'error',
                    title: 'Não foram encontrados dados para o usuário informado!',
                    showConfirmButton: false,
                    timer: 2500
                })

                return
            }

            var dataSet = [];

            for (let i = 0; i < obj.length; i++) {

                dataSet[i] = [obj[i].cep, obj[i].public_place, obj[i].complement, obj[i].district, obj[i].city, obj[i].state, obj[i].ddd, obj[i].created_at];

            }

            $('#principal_table').DataTable({
                scrollX: true,
                destroy: true,
                language: {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                },
                data: dataSet,
                columns: [
                    { title: "Cep" },
                    { title: "Logradouro" },
                    { title: "Complemento" },
                    { title: "Bairro" },
                    { title: "Localidade" },
                    { title: "UF" },
                    { title: "DDD" },
                    { title: "Data da Consulta" }
                ]
            })
        },error: function() {
            Swal.fire({
                position: 'top-right',
                icon: 'error',
                title: 'Eita!!! Não consegui buscar seus dados! Contate nosso adm!',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
})