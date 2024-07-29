const API_URL = 'http://localhost:8081/tarefa'; // Atualize com o URL correto da sua API

enum Status {
    NAOINICIADA = 'NAOINICIADA',
    EMPROGRESSO = 'EMPROGRESSO',
    CONCLUIDA = 'CONCLUIDA'
}

interface Tarefa {
    id?: string;
    titulo: string;
    descricao: string;
    status?: Status;
    dataVencimento: string;
    createdAt?: string;
    updatedAt?: string;
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('add-task-form') as HTMLFormElement;
    const editForm = document.getElementById('edit-task-form') as HTMLFormElement;
    const modal = document.getElementById('edit-modal') as HTMLElement;
    const spanClose = document.getElementsByClassName('close')[0] as HTMLElement;

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const titulo = (document.getElementById('titulo') as HTMLInputElement).value;
        const descricao = (document.getElementById('descricao') as HTMLInputElement).value;
        const dataVencimento = (document.getElementById('dataVencimento') as HTMLInputElement).value;
        const status = (document.getElementById('status') as HTMLSelectElement).value as Status;

        const newTask: Tarefa = {
            titulo,
            descricao,
            dataVencimento,
            status,
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString()
        };

        await createTarefa(newTask);
        await fetchTarefas();
    });

    async function fetchTarefas() {
        try {
            const response = await fetch(`${API_URL}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }

            const tarefas: Tarefa[] = await response.json();
            const naoIniciadoColuna = document.getElementById('nao-iniciado');
            const emProgressoColuna = document.getElementById('em-progresso');
            const concluidoColuna = document.getElementById('concluido');
            
            if (naoIniciadoColuna) naoIniciadoColuna.innerHTML = '';
            if (emProgressoColuna) emProgressoColuna.innerHTML = '';
            if (concluidoColuna) concluidoColuna.innerHTML = '';

            // Monta as colunas com as tarefas
            tarefas.forEach(tarefa => {
                console.log(tarefa);
                let coluna: HTMLElement | null = null;
                switch (tarefa.status) {
                    case Status.NAOINICIADA:
                        coluna = naoIniciadoColuna;
                        break;
                    case Status.EMPROGRESSO:
                        coluna = emProgressoColuna;
                        break;
                    case Status.CONCLUIDA:
                        coluna = concluidoColuna;
                        break;
                    default:
                        console.error('Status inválido:', tarefa.status);
                        return;
                }
                if (coluna) {
                    const div = document.createElement('div');
                    div.classList.add('card');
                    const card = `
                        <span class="titulo-card">${tarefa.titulo}</span>
                        <span class="descricao-card">${tarefa.descricao}</span>
                        <div class="buttons-card">
                            <button class="btn-editar" data-id="${tarefa.id}">Editar</button>
                            <button class="btn-excluir" data-id="${tarefa.id}">Excluir</button>
                        </div>`;
                    div.innerHTML = card;
                    coluna.appendChild(div);
                }
            });

            // Botão excluir
            document.querySelectorAll('.btn-excluir').forEach(button => {
                button.addEventListener('click', async (event) => {
                    const target = event.target as HTMLButtonElement;
                    const tarefaId = target.dataset.id;
                    if (tarefaId) {
                        await deleteTarefa(tarefaId);
                        // Recarrega a lista
                        await fetchTarefas(); 
                    }
                });
            });

            // Botão editar
            document.querySelectorAll('.btn-editar').forEach(button => {
                button.addEventListener('click', async (event) => {
                    const target = event.target as HTMLButtonElement;
                    const tarefaId = target.dataset.id;
                    if (tarefaId) {
                        openEditForm(tarefaId);
                    }
                });
            });

        } catch (error) {
            console.error('Error fetching tarefas:', error);
        }
    }

    async function createTarefa(tarefa: Tarefa) {
        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(tarefa)
            });

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }

            const result = await response.json();
            console.log(result);
        } catch (error) {
            console.error('Error creating tarefa:', error);
        }
    }

    async function deleteTarefa(tarefaId: string) {
        try {
            const response = await fetch(`${API_URL}/${tarefaId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }

            const result = await response.json();
            console.log(result);
        } catch (error) {
            console.error('Error deleting tarefa:', error);
        }
    }
    // criacao da modal
    function openEditForm(tarefaId: string) {
        fetch(`${API_URL}/${tarefaId}`)
            .then(response => response.json())
            .then(tarefa => {
                console.log(tarefa);
                (document.getElementById('edit-task-id') as HTMLInputElement).value = tarefa.id || '';
                (document.getElementById('edit-titulo') as HTMLInputElement).value = tarefa.titulo || '';
                (document.getElementById('edit-descricao') as HTMLInputElement).value = tarefa.descricao || '';
                (document.getElementById('edit-dataVencimento') as HTMLInputElement).value = tarefa.dataVencimento || '';
                (document.getElementById('edit-status') as HTMLSelectElement).value = tarefa.status || Status.NAOINICIADA;
                modal.style.display = 'block';
            })
            .catch(error => console.error('Error fetching tarefa:', error));
    }

    spanClose.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }

    editForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const tarefaId = (document.getElementById('edit-task-id') as HTMLInputElement).value;
        const titulo = (document.getElementById('edit-titulo') as HTMLInputElement).value;
        const descricao = (document.getElementById('edit-descricao') as HTMLInputElement).value;
        const dataVencimento = (document.getElementById('edit-dataVencimento') as HTMLInputElement).value;
        const status = (document.getElementById('edit-status') as HTMLSelectElement).value as Status;

        if (!tarefaId) {
            console.error('ID da tarefa não fornecido');
            return;
        }

        const updatedTask: Partial<Tarefa> = {
            titulo,
            descricao,
            dataVencimento,
            status,
        };

        try {
            const response = await fetch(`${API_URL}/${tarefaId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedTask)
            });

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }

            const result = await response.json();
            console.log(result);
            modal.style.display = 'none';
            await fetchTarefas();
        } catch (error) {
            console.error('Error updating tarefa:', error);
        }
    });

    fetchTarefas();
});
