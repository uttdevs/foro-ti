import { Link } from "react-router-dom"
import Img from "./Img"
import "./agenda.css"

/* Datos */

const navegacion = [
  { titulo: "Temáticas", to: "/#tematicas", src: "/icono-ia.png", fallback: "🧠", variante: "cian" },
  { titulo: "Mapa del Evento", to: "/#mapa", src: "/icono-mapa.png", fallback: "📍", variante: "turquesa" },
  { titulo: "Agenda", to: "/agenda", src: "/icono-agenda.png", fallback: "📅", variante: "violeta", activo: true },
]

const agendaJueves = [
  { hora: "08:00 - 09:00", actividad: "Registro y firma"},
  { hora: "09:00 - 09:30", actividad: "Inauguración" },
  { hora: "09:30 - 10:30", actividad: "Conferencia magistral", detalle: "Dr. Eduardo Berra Villaseñor" },
  { hora: "10:30 - 11:00", actividad: "Presentación de proyectos"},
  { hora: "11:00 - 11:30", actividad: "Break" },
  { hora: "11:30 - 13:00", actividad: "Mesas de trabajo simultáneas"},
  { hora: "13:00 - 14:00", actividad: "Comida" },
  { hora: "14:30 - 18:00", actividad: "Mesas de trabajo"},
]

const agendaViernes = [
  { hora: "09:00 - 10:00", actividad: "Inicio del evento"},
  { hora: "11:00 - 13:00", actividad: "Torneo de videojuegos",etiqueta: "FIFA · KOF · Street Fighter" },
  { hora: "13:00", actividad: "Premiación"},
]

/* Una columna (un día)  */

function DiaAgenda({ titulo, color, items, }) {
  return (
    <div className={`dia dia--${color}`}>
      <span className="dia__pastilla">{titulo}</span>

      <ul className="dia__lista">
        {items.map((fila) => (
          <li key={fila.hora} className="dia__fila">
            <p className="dia__hora">{fila.hora}</p>

            <div>
              <p className="dia__actividad">{fila.actividad}</p>
              {fila.detalle && <p className="dia__detalle">{fila.detalle}</p>}
              {fila.etiqueta && <span className="dia__etiqueta">{fila.etiqueta}</span>}
            </div>
          </li>
        ))}
      </ul>
   
    </div>
  )
}

/*  Página  */

function Agenda() {
  return (
    <main className="agenda-page">
      {/* Navegación superior */}
      <nav className="agenda-nav" aria-label="Secciones del foro">
        {navegacion.map((item) => (
          <Link
            key={item.titulo}
            to={item.to}
            className={`agenda-nav__item agenda-nav__item--${item.variante} ${item.activo ? "agenda-nav__item--activo" : ""}`}
            aria-current={item.activo ? "page" : undefined}
          >
            <span className="agenda-nav__icono">
              <Img
                src={item.src}
                alt=""
                fallback={item.fallback}
                fallbackClass="agenda-nav__emoji"
              />
            </span>
            <span>{item.titulo}</span>
          </Link>
        ))}
      </nav>

      {/* Panel de la agenda */}
      <section className="agenda-panel">
        <h1 className="agenda-panel__titulo">Agenda · ForoTI 2026</h1>

        <div className="agenda-dias">
          <DiaAgenda titulo="Jueves 26 de noviembre" color="cian" items={agendaJueves} />
          <DiaAgenda titulo="Viernes 27 de noviembre" color="fucsia" items={agendaViernes}>
</DiaAgenda>
        </div>
      </section>

      <Link to="/" className="agenda-volver">
         Volver al inicio
      </Link>
    </main>
  )
}

export default Agenda