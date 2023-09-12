<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">   
            <h3>Usuarios</h3>
            <button type="button" class="btn btn-success" @click="crear()">Crear usuario</button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" ref="usuarioModal" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="usuarioModalLabel">{{ editando ? 'Editar': 'Crear' }} usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FormUsuarioComponent 
                            :data_editar="data_editar"
                            :editando="editando"
                            @submit="modal.hide(), editando = false, getUsuarios()"
                            @cerrar="modal.hide(), editando = false"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th scope="col">id</th>
                    <th scope="col">nombre</th>
                    <th scope="col">email</th>
                    <th scope="col">admin</th>
                    <th scope="col">estado</th>
                    <th scope="col">acciones</th>
                </thead>
                <tbody>
                    <tr v-for="usuario in usuarios">
                        <th scope="row">{{ usuario.id }}</th>
                        <td>{{ usuario.nombre }}</td>
                        <td>{{ usuario.email }}</td>
                        <td>{{ usuario.admin ? 'Si' : 'No'}}</td>
                        <td>{{ usuario.estado ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" @click="editar(usuario)">Editar</button>
                                <button class="btn btn-sm" @click="cambiarEstado(usuario)" :class="usuario.estado ? 'btn-danger' : 'btn-success'">{{ usuario.estado ? 'Inactivar' : 'Activar' }}</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</template>
<script>
import FormUsuarioComponent from './FormUsuarioComponent';
import { Modal } from 'bootstrap'
export default {
    components: {
        FormUsuarioComponent
    },

    data(){
        return {
            usuarios: [],
            modal: null,
            editando: false,
            data_editar: null
        }
    },

    mounted(){
        this.modal = new Modal(this.$refs.usuarioModal)
        this.getUsuarios();
    },

    methods: {

        async getUsuarios(){
            try {
                const response = await this.axios.get('/user')
                this.usuarios = response.data
            } catch (error) {
                console.log(error.response)
            }
        },

        async cambiarEstado(item){
            try {
                if(!confirm('Seguro que desea cambiar el estado de este item ' + item.nombre)){
                    return false;
                }
                const response = await this.axios.put('/user/cambiar-estado/' + item.id);
                this.$toastr.success('¡El recurso se actualizo con exito!', '¡Exelente!')
                this.getUsuarios();
            }catch (error) {
                console.log(error)
                console.log(error.response)
            }
        },  

        crear(){
            this.data_editar = null;
            this.editando = false;
            this.modal.show();
        },

        editar(item){
            this.data_editar = item;
            this.editando = true;
            this.modal.show();
        }

    }
}
</script>