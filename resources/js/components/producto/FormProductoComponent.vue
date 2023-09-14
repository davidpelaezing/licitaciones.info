<template>
    <form @submit.prevent="submit">

        <div class="alert alert-danger" role="alert" v-if="errores.length">
            <p v-for="error in errores">{{ error }}</p>
        </div> 

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" v-model="form.nombre" id="nombre" placeholder="Nombre ...">
        </div>

        <select class="form-select mb-3" v-model="form.categoria_id" aria-label="Default select example">
            <option selected :value="null">Selecciona una categoria</option>
            <option v-for="categoria in categorias" :value="categoria.id">{{ categoria.nombre }}</option>
        </select>

        <select class="form-select mb-3" v-model="form.tags" aria-label="Default select example" multiple>
            <option v-for="tag in tags" :value="tag.id">{{ tag.nombre }}</option>
        </select>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion</label>
            <textarea class="form-control" v-model="form.descripcion" id="descripcion" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" v-model="form.precio" id="precio" placeholder="precio ...">
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="precio" ref="inputImagen" placeholder="precio ..." @change="cargarImagen">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">{{ editando ? 'Editar' : 'Crear' }}</button>
            <button type="button" class="btn btn-danger" @click="$emit('cerrar')">Cancelar</button>
        </div>

    </form>
</template>
<script>

export default {

props: {
    data_editar: {
        type: Object,
        default: null
    },
    editando: {
        type: Boolean,
        default: false,
    }
},

data(){
    return {
        categorias: [],
        tags: [],
        form: {
            nombre: null,
            categoria_id: null,
            descripcion: null,
            precio: null,
            tags: [],
            imagen: null
        },
        errores: [],
    }
},

mounted(){
    this.getCategorias()
    this.getTags()
    this.editar() 
},

watch: {
    data_editar(nuevoValor, valorAnterior) {
        this.editar() 
    }
},

methods: {

    async getCategorias() {
        try {
            const response = await this.axios.get('/categoria');
            this.categorias = response.data;
        } catch (error) {
            console.log(error)
        }
    },

    async getTags() {
        try {
            const response = await this.axios.get('/tag');
            this.tags = response.data;
        } catch (error) {
            console.log(error)
        }
    },

    async submit(){
        try {

            // creamos el form data para poder cargar la imagen
            const request = new FormData();
            request.append('nombre', this.form.nombre);
            request.append('categoria_id', this.form.categoria_id);
            request.append('descripcion', this.form.descripcion);
            request.append('precio', this.form.precio);
            if(this.form.imagen != null){
                request.append('imagen', this.form.imagen);
            }

            for (var i = 0; i < this.form.tags.length; i++) {
                request.append('tags[]', this.form.tags[i]);
            }

            if (this.editando){
                await this.axios.post('/producto/actualizar/' + this.data_editar.id, request);
                this.$snotify.success('¡El recurso se actualizo con exito!', '¡Exelente!')
            }else{
                await this.axios.post('/producto/crear', request);
                this.$snotify.success('¡El recurso se creo con exito!', '¡Exelente!')
            }
            
            this.limpiar()
            this.$emit('submit')
        } catch (error) {
            if(error.response.status === 422){
                this.errores = Object.values(error.response.data).reduce((accumulator, currentArray) => {
                    return accumulator.concat(currentArray);
                }, []);
            }   
            this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
        }
    },

    editar(){
        this.limpiar()
        if(this.editando){
            this.form.nombre = this.data_editar.nombre
            this.form.categoria_id = this.data_editar.categoria_id
            this.form.descripcion = this.data_editar.descripcion
            this.form.precio = this.data_editar.precio
            this.form.tags = this.data_editar.tags.map(item => {
                return item.id
            })
        }
    },

    cargarImagen(event) {
      this.form.imagen = event.target.files[0];
    },

    limpiar(){
        this.form.nombre = null
        this.form.categoria_id = null
        this.form.descripcion = null
        this.form.precio = null
        this.form.tags = []
        this.form.imagen = null
        this.$refs.inputImagen.value = null
        this.errores = []
    }

}

}

</script>