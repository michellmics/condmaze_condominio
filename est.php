<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estacionamento</title>
  <style>
    /* Estilos gerais omitidos para brevidade */

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      width: 90%;
      max-width: 400px;
    }

    .modal-header {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .modal-footer {
      margin-top: 10px;
      text-align: right;
    }

    .modal-footer button {
      margin-left: 10px;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    input:focus {
      border-color: #007bff;
    }
  </style>
</head>
<body>
  <h1>Controle de Estacionamento</h1>
  <div class="parking-lot">
    <!-- PHP gerando as vagas omitido para brevidade -->
  </div>

  <!-- Modal -->
  <div class="modal" id="inputModal">
    <div class="modal-content">
      <div class="modal-header">Preencha os dados do veículo</div>
      <input type="text" id="plateInput" maxlength="7" placeholder="Placa (máx. 7 caracteres)">
      <input type="text" id="apartmentInput" maxlength="5" placeholder="Apartamento (máx. 5 caracteres)">
      <input type="text" id="modelInput" maxlength="20" placeholder="Modelo do veículo (máx. 20 caracteres)">
      <div class="modal-footer">
        <button id="cancelButton">Cancelar</button>
        <button id="submitButton">Confirmar</button>
      </div>
    </div>
  </div>

  <script>
    const modal = document.getElementById('inputModal');
    const plateInput = document.getElementById('plateInput');
    const apartmentInput = document.getElementById('apartmentInput');
    const modelInput = document.getElementById('modelInput');
    let currentSlotId = null;

    // Abre o modal
    function openModal(slotId) {
      currentSlotId = slotId;
      plateInput.value = '';
      apartmentInput.value = '';
      modelInput.value = '';
      modal.style.display = 'flex';
    }

    // Fecha o modal
    function closeModal() {
      modal.style.display = 'none';
      currentSlotId = null;
    }

    document.querySelectorAll('.slot').forEach(slot => {
      slot.addEventListener('click', () => openModal(slot.dataset.id));
    });

    document.getElementById('cancelButton').addEventListener('click', closeModal);

    document.getElementById('submitButton').addEventListener('click', () => {
      const plate = plateInput.value.trim();
      const apartment = apartmentInput.value.trim();
      const model = modelInput.value.trim();

      if (!/^[A-Z0-9]{1,7}$/.test(plate)) {
        alert("Placa inválida! Use apenas letras e números (máximo 7 caracteres).");
        return;
      }

      if (!/^\d{1,5}$/.test(apartment)) {
        alert("Apartamento inválido! Use apenas números (máximo 5 caracteres).");
        return;
      }

      if (model.length === 0 || model.length > 20) {
        alert("Modelo inválido! Máximo de 20 caracteres.");
        return;
      }

      fetch('update_slot.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          id: currentSlotId,
          plate: plate,
          apartment: apartment,
          vehicle_model: model,
          entry_time: new Date().toLocaleString('pt-BR')
        })
      })
      .then(() => {
        closeModal();
        location.reload();
      });
    });
  </script>
</body>
</html>
