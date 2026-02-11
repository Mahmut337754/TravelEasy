const Dashboard = () => {
  return (
    <div className="dashboard">
      <h2>Dashboard</h2>
      <div className="dashboard-grid">
        <div className="dashboard-card">
          <h3>Totaal Boekingen</h3>
          <p className="stat-value">0</p>
        </div>
        <div className="dashboard-card">
          <h3>Omzet</h3>
          <p className="stat-value">€0</p>
        </div>
        <div className="dashboard-card">
          <h3>Actieve Klanten</h3>
          <p className="stat-value">0</p>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
