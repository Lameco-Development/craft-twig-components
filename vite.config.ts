export default ({command}) => ({
    base: command === 'serve' ? '' : '/dist/',
    build: {
        emptyOutDir: true,
        manifest: true,
        watch: true,
        outDir: './src/web/dist/',
        rollupOptions: {
            input: {
                app: './src/assets/ts/app.ts',
            },
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
            }
        },
    },
    server: {
        port: 8000,
        hmr: {
            host: 'localhost',
        }
    },
});
