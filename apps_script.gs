// ===== CONFIGURACIÓN (aquí cambias tu horario) =====
const CONFIG = {
  horaInicio: 10,               // abres a las 10:00
  horaFin: 19,                  // última cita termina a las 19:00
  duracionMin: 60,              // cada cita dura 60 minutos
  diasAbiertos: [1, 2, 3, 4, 5, 6]  // 0=Dom, 1=Lun ... 6=Sáb
};

// ===== FUNCIÓN 1: calcula qué horas están libres en un día =====
function horasDisponibles(fechaTexto) {
  const partes = fechaTexto.split("-");          // "2026-11-20" -> ["2026","11","20"]
  const anio = Number(partes[0]);
  const mes  = Number(partes[1]) - 1;            // los meses empiezan en 0
  const dia  = Number(partes[2]);

  // Si es un día que no abres, no hay horarios
  const diaSemana = new Date(anio, mes, dia).getDay();
  if (!CONFIG.diasAbiertos.includes(diaSemana)) return [];

  const calendario = CalendarApp.getDefaultCalendar();
  const libres = [];

  for (let hora = CONFIG.horaInicio; hora < CONFIG.horaFin; hora++) {
    const inicio = new Date(anio, mes, dia, hora, 0);
    const fin = new Date(inicio.getTime() + CONFIG.duracionMin * 60000);

    // No ofrecemos horas que ya pasaron
    if (inicio < new Date()) continue;

    // Si el calendario NO tiene eventos en ese rango, está libre
    if (calendario.getEvents(inicio, fin).length === 0) {
      libres.push(("0" + hora).slice(-2) + ":00");   // 9 -> "09:00"
    }
  }
  return libres;
}

// ===== FUNCIÓN 2: responde cuando la página PREGUNTA horarios =====
function doGet(e) {
  const horas = horasDisponibles(e.parameter.fecha);
  return ContentService
    .createTextOutput(JSON.stringify(horas))
    .setMimeType(ContentService.MimeType.JSON);
}

// ===== FUNCIÓN 3: responde cuando la página RESERVA una cita =====
function doPost(e) {
  // El "candado" evita que dos personas aparten la misma hora al mismo tiempo
  const candado = LockService.getScriptLock();
  candado.waitLock(10000);

  try {
    const datos = JSON.parse(e.postData.contents);

    // Revisamos otra vez que la hora siga libre
    const libres = horasDisponibles(datos.fecha);
    if (!libres.includes(datos.hora)) {
      return responder({ ok: false, mensaje: "Ese horario ya fue apartado. Elige otro." });
    }

    const f = datos.fecha.split("-");
    const hora = Number(datos.hora.split(":")[0]);
    const inicio = new Date(Number(f[0]), Number(f[1]) - 1, Number(f[2]), hora, 0);
    const fin = new Date(inicio.getTime() + CONFIG.duracionMin * 60000);

    // Creamos el evento y le mandamos invitación al cliente
    CalendarApp.getDefaultCalendar().createEvent(
      datos.servicio + " - " + datos.nombre,
      inicio,
      fin,
      {
        description: "Cliente: " + datos.nombre +
                     "\nWhatsApp: " + datos.whatsapp +
                     "\nCorreo: " + datos.correo,
        guests: datos.correo,
        sendInvites: true
      }
    );

    return responder({ ok: true, mensaje: "¡Cita agendada! Te enviamos una invitación a tu correo." });

  } finally {
    candado.releaseLock();   // soltamos el candado pase lo que pase
  }
}

// ===== Función auxiliar para devolver respuestas en formato JSON =====
function responder(objeto) {
  return ContentService
    .createTextOutput(JSON.stringify(objeto))
    .setMimeType(ContentService.MimeType.JSON);
}
