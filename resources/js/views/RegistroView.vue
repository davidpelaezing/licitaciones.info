<template>
    <div class="row">
        <div class="col-md-5 mx-auto">
            <h2>Registro de usuario</h2>
            <FormRegistroComponent />
        </div>
    </div>
</template>
<script>
import FormRegistroComponent from '../components/registro/FormRegistroComponent.vue';
export default {

    components: {
    FormRegistroComponent,
}

}
</script>