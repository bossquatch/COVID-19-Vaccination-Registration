<template>
    <div id="qr-reader-app" class="bg-dark">
        <qrcode-stream @decode="onDecode" />
    </div>
</template>
<script>
import { QrcodeStream } from "vue-qrcode-reader";

export default {
    components: { QrcodeStream },

    methods: {
        onDecode (decodedURL) {
            window.location.href = decodedURL;
        }        
    }
}
</script>
