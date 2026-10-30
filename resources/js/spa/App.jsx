import { Routes, Route } from "react-router-dom"
import Inicio from "./Inicio"
import Talleres from "./Talleres"
import Agenda from "./Agenda"

function App() {
  return (
    <Routes>
      <Route path="/" element={<Inicio />} />
      <Route path="/talleres" element={<Talleres />} />
      <Route path="/agenda" element={<Agenda />} />
    </Routes>
  )
}

export default App