<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">   
            <h3>Categorias</h3>
            <button type="button" class="btn btn-success" @click="crear()">Crear categoria</button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" ref="categoriaModal" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="categoriaModalLabel">{{ editando ? 'Editar': 'Crear' }} categoria</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FormCategoriaComponent 
                            :data_editar="data_editar"
                            :editando="editando"
                            @submit="modal.hide(), editando = false, getCategorias()"
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
                    <th scope="col">estado</th>
                    <th scope="col">acciones</th>
                </thead>
                <tbody>
                    <tr v-for="categoria in categorias">
                        <th scope="row">{{ categoria.id }}</th>
                        <td>{{ categoria.nombre }}</td>
                        <td>{{ categoria.estado ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" @click="editar(categoria)">Editar</button>
                                <button class="btn btn-sm" @click="cambiarEstado(categoria)" :class="categoria.estado ? 'btn-danger' : 'btn-success'">{{ categoria.estado ? 'Inactivar' : 'Activar' }}</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination :data="paginacion" :limit="2" @pagination-change-page="getCategorias"></pagination>
    </div>
    
</template>
<script>
import FormCategoriaComponent from './FormCategoriaComponent';
import { Modal } from 'bootstrap'
export default {
    components: {
        FormCategoriaComponent
    },

    data(){
        return {
            categorias: [],
            paginacion: null,
            modal: null,
            editando: false,
            data_editar: null
        }
    },

    mounted(){
        this.modal = new Modal(this.$refs.categoriaModal)
        this.getCategorias();
    },

    methods: {

        async getCategorias(page = 1){
            try {
                const response = await this.axios.get('/categoria?page=' + page)
                this.categorias = response.data.data
                this.paginacion = response.data
            } catch (error) {
                console.log(error.response)
            }
        },

        async cambiarEstado(item){
            try {
                if(!confirm('Seguro que desea cambiar el estado de este item ' + item.nombre)){
                    return false;
                }
                const response = await this.axios.put('/categoria/cambiar-estado/' + item.id);
                this.$snotify.success('¡El recurso se actualizo con exito!', '¡Exelente!')
                this.getCategorias();
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