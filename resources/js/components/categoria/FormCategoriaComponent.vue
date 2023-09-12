<template>
    <form @submit.prevent="submit">

        <div class="alert alert-danger" role="alert" v-if="errores.length">
            <p v-for="error in errores">{{ error }}</p>
        </div> 

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" v-model="form.nombre" id="nombre" placeholder="Nombre ...">
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
        form: {
            nombre: null,
        },
        errores: [],
    }
},

mounted(){
    this.editar() 
},

watch: {
    data_editar(nuevoValor, valorAnterior) {
        this.editar() 
    }
},

methods: {

    async submit(){
        try {
            if (this.editando){
                await this.axios.put('/categoria/actualizar/' + this.data_editar.id, this.form);
                this.$toastr.success('¡El recurso se actualizo con exito!', '¡Exelente!')
            }else{
                await this.axios.post('/categoria/crear', this.form);
                this.$toastr.success('¡El recurso se creo con exito!', '¡Exelente!')
            }
            this.limpiar()
            this.$emit('submit')
        } catch (error) {
            this.errores = Object.values(error.response.data).reduce((accumulator, currentArray) => {
                return accumulator.concat(currentArray);
            }, []);
        }
    },

    editar(){
        this.limpiar()
        if(this.editando){
            this.form.nombre = this.data_editar.nombre
        }
        
    },

    limpiar(){
        this.form.nombre = null
        this.errores = []
    }

}

}

</script>