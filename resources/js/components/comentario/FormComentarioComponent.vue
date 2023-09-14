<template>
    <form @submit.prevent="submit">

        <div class="alert alert-danger" role="alert" v-if="errores.length">
            <p v-for="error in errores">{{ error }}</p>
        </div>

        <select class="form-select mb-3" v-model="form.producto_id" aria-label="Default select example">
            <option selected :value="null">Selecciona un producto</option>
            <option v-for="producto in productos" :value="producto.id">{{ producto.nombre }}</option>
        </select>

        <div class="mb-3">
            <textarea class="form-control" v-model="form.texto" id="descripcion" rows="3" placeholder="Escribe tu comentario aqui"></textarea>
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
        productos: [],
        form: {
            producto_id: null,
            texto: null,
        },
        errores: [],
    }
},

mounted(){
    this.editar()
    this.getProductos();
},

watch: {
    data_editar() {
        this.editar() 
    }
},

methods: {

    async submit(){
        try {
            if (this.editando){
                await this.axios.put('/comentario/actualizar/' + this.data_editar.id, this.form);
                this.$snotify.success('¡El recurso se actualizo con exito!', '¡Exelente!')
            }else{
                await this.axios.post('/comentario/crear', this.form);
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

    async getProductos(){
        try {
            const response = await this.axios.get('/producto')
            this.productos = response.data
        }catch(error) {
            this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
        }
    },

    editar(){
        this.limpiar()
        if(this.editando){
            this.form.producto_id = this.data_editar.producto_id
            this.form.texto = this.data_editar.texto
        }
        
    },

    limpiar(){
        this.form.producto_id = null
        this.form.texto = null
        this.errores = []
    }

}

}

</script>