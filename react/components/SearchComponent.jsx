import React from 'react';
import ReactDOM from 'react-dom/client'; 

const SearchComponent = () => {
  console.log("SearchComponent");

  return (
    <div id="searchbar">
      test
    </div>
  );
};

export default SearchComponent;

// Wait for the DOM to load before rendering
document.addEventListener('DOMContentLoaded', () => {
  const rootElement = document.getElementById('react-root-searchbar');
  if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(<SearchComponent />);
  } else {
    console.error('Target container #react-root-searchbar not found');
  }
});