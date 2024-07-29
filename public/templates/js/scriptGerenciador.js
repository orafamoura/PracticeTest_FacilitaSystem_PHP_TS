"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var API_URL = 'http://localhost:8081/tarefa'; // Atualize com o URL correto da sua API
var Status;
(function (Status) {
    Status["NAOINICIADA"] = "NAOINICIADA";
    Status["EMPROGRESSO"] = "EMPROGRESSO";
    Status["CONCLUIDA"] = "CONCLUIDA";
})(Status || (Status = {}));
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('add-task-form');
    var editForm = document.getElementById('edit-task-form');
    var modal = document.getElementById('edit-modal');
    var spanClose = document.getElementsByClassName('close')[0];
    form.addEventListener('submit', function (event) { return __awaiter(void 0, void 0, void 0, function () {
        var titulo, descricao, dataVencimento, status, newTask;
        return __generator(this, function (_a) {
            switch (_a.label) {
                case 0:
                    event.preventDefault();
                    titulo = document.getElementById('titulo').value;
                    descricao = document.getElementById('descricao').value;
                    dataVencimento = document.getElementById('dataVencimento').value;
                    status = document.getElementById('status').value;
                    newTask = {
                        titulo: titulo,
                        descricao: descricao,
                        dataVencimento: dataVencimento,
                        status: status,
                        createdAt: new Date().toISOString(),
                        updatedAt: new Date().toISOString()
                    };
                    return [4 /*yield*/, createTarefa(newTask)];
                case 1:
                    _a.sent();
                    return [4 /*yield*/, fetchTarefas()];
                case 2:
                    _a.sent();
                    return [2 /*return*/];
            }
        });
    }); });
    function fetchTarefas() {
        return __awaiter(this, void 0, void 0, function () {
            var response, tarefas, naoIniciadoColuna_1, emProgressoColuna_1, concluidoColuna_1, error_1;
            var _this = this;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        _a.trys.push([0, 3, , 4]);
                        return [4 /*yield*/, fetch("".concat(API_URL), {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })];
                    case 1:
                        response = _a.sent();
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return [4 /*yield*/, response.json()];
                    case 2:
                        tarefas = _a.sent();
                        naoIniciadoColuna_1 = document.getElementById('nao-iniciado');
                        emProgressoColuna_1 = document.getElementById('em-progresso');
                        concluidoColuna_1 = document.getElementById('concluido');
                        if (naoIniciadoColuna_1)
                            naoIniciadoColuna_1.innerHTML = '';
                        if (emProgressoColuna_1)
                            emProgressoColuna_1.innerHTML = '';
                        if (concluidoColuna_1)
                            concluidoColuna_1.innerHTML = '';
                        tarefas.forEach(function (tarefa) {
                            console.log(tarefa);
                            var coluna = null;
                            switch (tarefa.status) {
                                case Status.NAOINICIADA:
                                    coluna = naoIniciadoColuna_1;
                                    break;
                                case Status.EMPROGRESSO:
                                    coluna = emProgressoColuna_1;
                                    break;
                                case Status.CONCLUIDA:
                                    coluna = concluidoColuna_1;
                                    break;
                                default:
                                    console.error('Status inválido:', tarefa.status);
                                    return;
                            }
                            if (coluna) {
                                var div = document.createElement('div');
                                div.classList.add('card');
                                var card = "\n                        <span class=\"titulo-card\">".concat(tarefa.titulo, "</span>\n                        <span class=\"descricao-card\">").concat(tarefa.descricao, "</span>\n                        <div class=\"buttons-card\">\n                            <button class=\"btn-editar\" data-id=\"").concat(tarefa.id, "\">Editar</button>\n                            <button class=\"btn-excluir\" data-id=\"").concat(tarefa.id, "\">Excluir</button>\n                        </div>");
                                div.innerHTML = card;
                                coluna.appendChild(div);
                            }
                        });
                        // Adiciona eventos para os botões de excluir
                        document.querySelectorAll('.btn-excluir').forEach(function (button) {
                            button.addEventListener('click', function (event) { return __awaiter(_this, void 0, void 0, function () {
                                var target, tarefaId;
                                return __generator(this, function (_a) {
                                    switch (_a.label) {
                                        case 0:
                                            target = event.target;
                                            tarefaId = target.dataset.id;
                                            if (!tarefaId) return [3 /*break*/, 3];
                                            return [4 /*yield*/, deleteTarefa(tarefaId)];
                                        case 1:
                                            _a.sent();
                                            // Recarrega a lista
                                            return [4 /*yield*/, fetchTarefas()];
                                        case 2:
                                            // Recarrega a lista
                                            _a.sent();
                                            _a.label = 3;
                                        case 3: return [2 /*return*/];
                                    }
                                });
                            }); });
                        });
                        // Botão editar
                        document.querySelectorAll('.btn-editar').forEach(function (button) {
                            button.addEventListener('click', function (event) { return __awaiter(_this, void 0, void 0, function () {
                                var target, tarefaId;
                                return __generator(this, function (_a) {
                                    target = event.target;
                                    tarefaId = target.dataset.id;
                                    if (tarefaId) {
                                        openEditForm(tarefaId);
                                    }
                                    return [2 /*return*/];
                                });
                            }); });
                        });
                        return [3 /*break*/, 4];
                    case 3:
                        error_1 = _a.sent();
                        console.error('Error fetching tarefas:', error_1);
                        return [3 /*break*/, 4];
                    case 4: return [2 /*return*/];
                }
            });
        });
    }
    function createTarefa(tarefa) {
        return __awaiter(this, void 0, void 0, function () {
            var response, result, error_2;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        _a.trys.push([0, 3, , 4]);
                        return [4 /*yield*/, fetch(API_URL, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(tarefa)
                            })];
                    case 1:
                        response = _a.sent();
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return [4 /*yield*/, response.json()];
                    case 2:
                        result = _a.sent();
                        console.log(result);
                        return [3 /*break*/, 4];
                    case 3:
                        error_2 = _a.sent();
                        console.error('Error creating tarefa:', error_2);
                        return [3 /*break*/, 4];
                    case 4: return [2 /*return*/];
                }
            });
        });
    }
    function deleteTarefa(tarefaId) {
        return __awaiter(this, void 0, void 0, function () {
            var response, result, error_3;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        _a.trys.push([0, 3, , 4]);
                        return [4 /*yield*/, fetch("".concat(API_URL, "/").concat(tarefaId), {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })];
                    case 1:
                        response = _a.sent();
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return [4 /*yield*/, response.json()];
                    case 2:
                        result = _a.sent();
                        console.log(result);
                        return [3 /*break*/, 4];
                    case 3:
                        error_3 = _a.sent();
                        console.error('Error deleting tarefa:', error_3);
                        return [3 /*break*/, 4];
                    case 4: return [2 /*return*/];
                }
            });
        });
    }
    function openEditForm(tarefaId) {
        fetch("".concat(API_URL, "/").concat(tarefaId))
            .then(function (response) { return response.json(); })
            .then(function (tarefa) {
            console.log(tarefa);
            document.getElementById('edit-task-id').value = tarefa.id || '';
            document.getElementById('edit-titulo').value = tarefa.titulo || '';
            document.getElementById('edit-descricao').value = tarefa.descricao || '';
            document.getElementById('edit-dataVencimento').value = tarefa.dataVencimento || '';
            document.getElementById('edit-status').value = tarefa.status || Status.NAOINICIADA;
            modal.style.display = 'block';
        })
            .catch(function (error) { return console.error('Error fetching tarefa:', error); });
    }
    spanClose.onclick = function () {
        modal.style.display = 'none';
    };
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
    editForm.addEventListener('submit', function (event) { return __awaiter(void 0, void 0, void 0, function () {
        var tarefaId, titulo, descricao, dataVencimento, status, updatedTask, response, result, error_4;
        return __generator(this, function (_a) {
            switch (_a.label) {
                case 0:
                    event.preventDefault();
                    tarefaId = document.getElementById('edit-task-id').value;
                    titulo = document.getElementById('edit-titulo').value;
                    descricao = document.getElementById('edit-descricao').value;
                    dataVencimento = document.getElementById('edit-dataVencimento').value;
                    status = document.getElementById('edit-status').value;
                    if (!tarefaId) {
                        console.error('ID da tarefa não fornecido');
                        return [2 /*return*/];
                    }
                    updatedTask = {
                        titulo: titulo,
                        descricao: descricao,
                        dataVencimento: dataVencimento,
                        status: status,
                    };
                    _a.label = 1;
                case 1:
                    _a.trys.push([1, 5, , 6]);
                    return [4 /*yield*/, fetch("".concat(API_URL, "/").concat(tarefaId), {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(updatedTask)
                        })];
                case 2:
                    response = _a.sent();
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return [4 /*yield*/, response.json()];
                case 3:
                    result = _a.sent();
                    console.log(result);
                    modal.style.display = 'none';
                    return [4 /*yield*/, fetchTarefas()];
                case 4:
                    _a.sent();
                    return [3 /*break*/, 6];
                case 5:
                    error_4 = _a.sent();
                    console.error('Error updating tarefa:', error_4);
                    return [3 /*break*/, 6];
                case 6: return [2 /*return*/];
            }
        });
    }); });
    // Fetch tasks on page load
    fetchTarefas();
});
