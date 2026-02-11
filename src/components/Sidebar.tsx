import { Link } from 'react-router-dom';

const Sidebar = () => {
  return (
    <aside className="sidebar">
      <nav className="sidebar-nav">
        <Link to="/" className="nav-item">Dashboard</Link>
        <Link to="/bookings" className="nav-item">Boekingen</Link>
        <Link to="/customers" className="nav-item">Klanten</Link>
        <Link to="/destinations" className="nav-item">Bestemmingen</Link>
        <Link to="/reports" className="nav-item">Rapportages</Link>
      </nav>
    </aside>
  );
};

export default Sidebar;
