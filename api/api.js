// routes/router.js
const express = require('express');
const router = express.Router();

// Corregido: Usar require para importar el controlador
const apiController = require('../controllers/apiController');  // Asegúrate de que la ruta sea correcta

// Ruta para manejar usuarios
router.get('/usuarios', apiController.getUsuarios);
router.post('/usuarios', apiController.createUsuario);

// Ruta para manejar productos
router.get('/productos', apiController.getProductos);
router.post('/productos', apiController.createProducto);

// Ruta para manejar pedidos
router.get('/pedidos', apiController.getPedidos);
router.post('/pedidos', apiController.createPedido);

module.exports = router;