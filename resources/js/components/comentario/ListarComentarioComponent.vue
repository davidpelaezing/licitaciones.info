<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">   
            <h3>comentarios</h3>
            <button type="button" class="btn btn-success" @click="crear()">Crear comentario</button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" ref="comentarioModal" id="comentarioModal" tabindex="-1" aria-labelledby="comentarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="comentarioModalLabel">{{ editando ? 'Editar': 'Crear' }} comentario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FormComentarioComponent 
                            :data_editar="data_editar"
                            :editando="editando"
                            @submit="modal.hide(), editando = false, getComentarios()"
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
                    <th scope="col">usuario</th>
                    <th scope="col">producto</th>
                    <th scope="col">texto</th>
                    <th scope="col">estado</th>
                    <th scope="col">acciones</th>
                </thead>
                <tbody>
                    <tr v-for="comentario in comentarios">
                        <th scope="row">{{ comentario.id }}</th>
                        <td>{{ comentario.user.nombre }}</td>
                        <td>{{ comentario.producto.nombre }}</td>
                        <td>{{ comentario.texto }}</td>
                        <td>{{ comentario.estado ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" @click="editar(comentario)">Editar</button>
                                <button class="btn btn-sm" @click="cambiarEstado(comentario)" :class="comentario.estado ? 'btn-danger' : 'btn-success'">{{ comentario.estado ? 'Inactivar' : 'Activar' }}</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination :data="paginacion" :limit="2" @pagination-change-page="getComentarios"></pagination>
    </div>
    
</template>
<script>
import FormComentarioComponent from './FormComentarioComponent';
import { Modal } from 'bootstrap'
export default {
    components: {
        FormComentarioComponent
    },

    data(){
        return {
            comentarios: [],
            paginacion: null,
            modal: null,
            editando: false,
            data_editar: null
        }
    },

    mounted(){
        this.modal = new Modal(this.$refs.comentarioModal)
        this.getComentarios();
    },

    methods: {

        async getComentarios(page = 1){
            try {
                const response = await this.axios.get('/comentario?page=' + page)
                this.comentarios = response.data.data
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
                const response = await this.axios.put('/comentario/cambiar-estado/' + item.id);
                this.$snotify.success('¡El recurso se actualizo con exito!', '¡Exelente!')
                this.getComentarios();
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