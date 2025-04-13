import { defineConfig } from 'cypress'

export default defineConfig({
    port: 3001,
    e2e: {
        baseUrl: 'http://host.docker.internal:3000',
        supportFile: false,
    },
})
