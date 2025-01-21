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
      height: 140px; /* Aumenta a altura para acomodar mais informações */
      border: 2px solid #333;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: 0.3s;
      position: relative;
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
    .entry-time, .vehicle-info {
      font-size: 12px;
      color: #fff;
      margin-top: 3px;
      text-align: center;
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
          $displayText = $slot['status'] === 'occupied' ? $slot['plate'] : 'Livre';
        
          // Verifica se há uma entrada de data e hora e a exibe, caso contrário, deixa em branco
          $entryTimeText = $slot['status'] === 'occupied' && !empty($slot['entry_time']) 
              ? "<div class='entry-time'>Entrada: {$slot['entry_time']}</div>" 
              : '';

          // Exibe as informações do veículo se a vaga estiver ocupada
          $vehicleInfo = $slot['status'] === 'occupied' && !empty($slot['vehicle_model']) 
              ? "<div class='vehicle-info'>{$slot['vehicle_model']} - Apt. {$slot['apartment']}</div>" 
              : '';

          echo "
              <div class='slot-wrapper'>
                  <div class='slot $statusClass' data-id='$id'>
                      $displayText
                      $entryTimeText
                      $vehicleInfo
                  </div>
                  <span class='slot-number'>Vaga $id</span>
              </div>
          ";
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
    const newPlate = prompt("Digite a placa do veículo:");
    const newApartment = prompt("Digite o número do apartamento:");
    const newModel = prompt("Digite o modelo do veículo:");
    const entryTime = formatDate(new Date());  // Usando a função formatDate para formatar a data e hora

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
