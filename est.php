<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estacionamento</title>
  <style>
    /* Estilo do corpo */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      text-align: center;
      background-color: #f4f7fa;
      margin: 0;
      padding: 0;
    }

    h1 {
      margin-top: 20px;
      font-size: 30px;
      color: #333;
    }

    /* Estilo do estacionamento */
    .parking-lot {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      justify-content: center;
      margin-top: 30px;
      padding: 0 15px;
    }

    .slot-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Estilo das vagas */
    .slot {
      width: 150px;
      height: 150px;
      border: 2px solid #ddd;
      background-color: #e0f7fa;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: 0.3s ease-in-out;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Vaga livre */
    .slot.free {
      background-color: #81c784;
      color: white;
    }

    /* Vaga ocupada */
    .slot.occupied {
      background-color: #e57373;
      color: white;
    }

    .slot-number {
      margin-top: 10px;
      font-size: 14px;
      color: #555;
      font-weight: bold;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.3);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 25px;
      border-radius: 12px;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
      font-size: 20px;
      margin-bottom: 15px;
      color: #333;
    }

    /* Estilo do botão */
    .modal-footer button {
      background-color: #00796b;
      color: white;
      padding: 10px 15px;
      margin-left: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .modal-footer button:hover {
      background-color: #004d40;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    input:focus {
      border-color: #00796b;
      outline: none;
    }
  </style>
</head>
<body>
  <h1>Controle de Estacionamento</h1>
  <div class="parking-lot">
    <?php
      $slots = json_decode(file_get_contents('slots.json'), true);

      foreach ($slots as $id => $slot) {
          $statusClass = $slot['status'] === 'occupied' ? 'occupied' : 'free';
          $displayText = $slot['status'] === 'occupied' 
              ? '<div>' . htmlspecialchars(strtoupper($slot['plate'])) . '</div>' . 
                '<div>' . htmlspecialchars(strtoupper($slot['vehicle_model'])) . '</div>' . 
                '<div>AP: ' . htmlspecialchars($slot['apartment']) . '</div>' . 
                '<div style="font-size: 12px; color: #666;">' . htmlspecialchars($slot['entry_time']) . '</div>'
              : 'Livre';

          echo '<div class="slot-wrapper">
                  <div class="slot ' . $statusClass . '" data-id="' . $id . '">' . $displayText . '</div>
                  <span class="slot-number">Vaga ' . $id . '</span>
                </div>';
      }
    ?>
  </div>

  <!-- Modal -->
  <div class="modal" id="inputModal">
    <div class="modal-content">
      <div class="modal-header">Preencha os dados do veículo</div>
      <input type="text" id="plateInput" maxlength="7" placeholder="Placa (máx. 7 caracteres)" oninput="this.value = this.value.toUpperCase()">
      <input type="text" id="apartmentInput" maxlength="5" placeholder="Apartamento (máx. 5 caracteres)">
      <input type="text" id="modelInput" maxlength="10" placeholder="Modelo do veículo (máx. 10 caracteres)" oninput="this.value = this.value.toUpperCase()">
      <div class="modal-footer">
        <button id="cancelButton">Cancelar</button>
        <button id="submitButton">Confirmar</button>
        <button id="freeButton">Liberar Vaga</button>
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

      if (model.length === 0 || model.length > 10) {
        alert("Modelo inválido! Máximo de 10 caracteres.");
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

    document.getElementById('freeButton').addEventListener('click', () => {
      if (confirm("Tem certeza de que deseja liberar esta vaga?")) {
        fetch('update_slot.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            id: currentSlotId,
            status: 'free',
            plate: '',
            apartment: '',
            vehicle_model: '',
            entry_time: ''
          })
        })
        .then(() => {
          closeModal();
          location.reload();
        });
      }
    });
  </script>
</body>
</html>
