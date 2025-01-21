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

    h1 {
      margin-top: 20px;
      font-size: 24px;
    }

    .parking-lot {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      justify-content: center;
      margin-top: 20px;
      padding: 0 10px;
    }

    .slot-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .slot {
      width: 150px;
      height: 150px;
      border: 2px solid #333;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: 0.3s ease-in-out;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .slot:hover {
      transform: scale(1.05);
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
      margin-top: 10px;
      font-size: 16px;
      color: #555;
    }

    .entry-time {
      font-size: 14px;
      color: #fff;
      margin-top: 5px;
    }

    .release-button {
      margin-top: 10px;
      padding: 5px 10px;
      font-size: 14px;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: white;
      cursor: pointer;
      transition: 0.3s ease-in-out;
    }

    .release-button:hover {
      background-color: #0056b3;
    }

    @media (max-width: 768px) {
      .slot {
        width: 120px;
        height: 120px;
      }

      .slot-number {
        font-size: 14px;
      }

      .release-button {
        font-size: 12px;
      }
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
                  <button class="release-button" data-id="' . $id . '">Liberar Vaga</button>
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

    document.querySelectorAll('.release-button').forEach(button => {
      button.addEventListener('click', () => {
        const slotId = button.dataset.id;
        const confirmRelease = confirm("Tem certeza de que deseja liberar esta vaga?");
        if (confirmRelease) {
          fetch('release_slot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: slotId })
          })
          .then(() => location.reload());
        }
      });
    });

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
