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
          $displayText = $slot['status'] === 'occupied' ? $slot['plate'] : 'Livre';
          
          // Verifica se há uma entrada de data e hora e a exibe, caso contrário, deixa em branco
          $entryTimeText = $slot['status'] === 'occupied' && !empty($slot['entry_time']) 
              ? "<div class='entry-time'>Entrada: {$slot['entry_time']}</div>" 
              : '';
      
          echo "
              <div class='slot-wrapper'>
                  <div class='slot $statusClass' data-id='$id'>$displayText</div>
                  <span class='slot-number'>Vaga $id</span>
                  $entryTimeText
              </div>
          ";
      }
      ?>
  </div>

  <script>
    document.querySelectorAll('.slot').forEach(slot => {
      slot.addEventListener('click', () => {
        const slotId = slot.dataset.id;
        const newPlate = prompt("Digite a placa (ou deixe vazio para liberar):");
        fetch('update_slot.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: slotId, plate: newPlate })
        }) 
        .then(() => location.reload());
      });
    });
  </script>
</body>
</html>
