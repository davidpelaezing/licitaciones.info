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
                    <th scope="col">online</th>
                    <th scope="col">estado</th>
                    <th scope="col">acciones</th>
                </thead>
                <tbody>
                    <tr v-for="usuario in usuarios">
                        <th scope="row">{{ usuario.id }}</th>
                        <td>{{ usuario.nombre }}</td>
                        <td>{{ usuario.email }}</td>
                        <td>{{ usuario.admin ? 'Si' : 'No'}}</td>
                        <td>
                            <div class="spinner-grow text-success" role="status" v-if="usuario.isActivo">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span v-else>Offline</span>
                        </td>
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
        <pagination :data="paginacion" :limit="2" @pagination-change-page="getUsuarios"></pagination>
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
            paginacion: null,
            modal: null,
            editando: false,
            data_editar: null
        }
    },

    mounted(){
        this.modal = new Modal(this.$refs.usuarioModal)
        this.getUsuarios();

        // Simulo tiempo real
        setInterval(() => {
            this.getUsuarios();
        }, 1 * 60 * 1000);
    },

    methods: {

        async getUsuarios(page = 1){
            try {
                const response = await this.axios.get('/user?page=' + page)
                this.usuarios = response.data.data
                this.paginacion = response.data
            } catch (error) {
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
            }
        },

        async cambiarEstado(item){
            try {
                if(!confirm('Seguro que desea cambiar el estado de este item ' + item.nombre)){
                    return false;
                }
                await this.axios.put('/user/cambiar-estado/' + item.id);
                this.$snotify.success('¡El recurso se actualizo con exito!', '¡Exelente!')
                this.getUsuarios();
            }catch (error) {
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
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