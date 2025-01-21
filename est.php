<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estacionamento</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
    }
    .parking-lot {
      display: grid;
      grid-template-columns: repeat(5, 100px);
      gap: 10px;
      justify-content: center;
      margin-top: 20px;
    }
    .slot-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .slot {
      width: 100px;
      height: 100px;
      border: 2px solid #333;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: 0.3s;
    }
    .slot.free {
      background-color: #4caf50;
      color: white;
    }
    .slot.occupied {
      background-color: #f44336;
      color: white;
    }
    .slot-number {
      margin-top: 5px;
      font-size: 14px;
      color: #555;
    }
    .entry-time {
      font-size: 12px;
      color: #fff;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <h1>Controle de Estacionamento</h1>
  <div class="parking-lot">
    <?php
      $slots = json_decode(file_get_contents('slots.json'), true); // Carrega as vagas do arquivo JSON

      foreach ($slots as $id => $slot) {
          $statusClass = $slot['status'] === 'occupied' ? 'occupied' : 'free';
          $displayText = $slot['status'] === 'occupied' 
              ? '<div>' . htmlspecialchars(strtoupper($slot['plate'])) . '</div>' .
                '<div>Modelo: ' . htmlspecialchars(strtoupper($slot['vehicle_model'])) . '</div>' .
                '<div>Apto: ' . htmlspecialchars($slot['apartment']) . '</div>' .
                '<div>Entrada: ' . htmlspecialchars($slot['entry_time']) . '</div>'
              : 'Livre';

          echo '<div class="slot-wrapper">
                  <div class="slot ' . $statusClass . '" data-id="' . $id . '">' . $displayText . '</div>
                  <span class="slot-number">Vaga ' . $id . '</span>
                </div>';
      }
    ?>
  </div>

  <script>
    // Função para formatar a data no formato DD/MM/YYYY HH:MM
    function formatDate(date) {
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      const hours = String(date.getHours()).padStart(2, '0');
      const minutes = String(date.getMinutes()).padStart(2, '0');
      
      return `${day}/${month}/${year} ${hours}:${minutes}`;
    }

    document.querySelectorAll('.slot').forEach(slot => {
      slot.addEventListener('click', () => {
        const slotId = slot.dataset.id;

        let newPlate = prompt("Digite a placa do veículo (máx. 7 caracteres):");
        if (newPlate) {
          newPlate = newPlate.toUpperCase().trim().slice(0, 7); // Limita a 7 caracteres e coloca em maiúsculas
          if (!/^[A-Z0-9]{1,7}$/.test(newPlate)) {
            alert("Placa inválida! Use apenas letras e números (máximo 7 caracteres).");
            return;
          }
        }

        let newApartment = prompt("Digite o número do apartamento:");
        if (newApartment) {
          newApartment = newApartment.trim();
          if (!/^\d+$/.test(newApartment)) {
            alert("Apartamento inválido! Use apenas números.");
            return;
          }
        }

        let newModel = prompt("Digite o modelo do veículo:");
        if (newModel) {
          newModel = newModel.toUpperCase().trim(); // Coloca em maiúsculas
          if (newModel.length === 0) {
            alert("Modelo inválido!");
            return;
          }
        }

        const entryTime = formatDate(new Date()); // Formata a data de entrada

        if (newPlate && newApartment && newModel) {
          fetch('update_slot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              id: slotId,
              plate: newPlate,
              apartment: newApartment,
              vehicle_model: newModel,
              entry_time: entryTime
            })
          }) 
          .then(() => location.reload());
        } else {
          alert("Todos os campos devem ser preenchidos!");
        }
      });
    });
  </script>
</body>
</html>
