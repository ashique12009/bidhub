<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <RouterLink class="navbar-brand" to="/">
        BidHub
      </RouterLink>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <RouterLink class="nav-link" to="/" exact-active-class="active">
              Home
            </RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/about">
              About
            </RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/products">
              Products
            </RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/auctions">
              Auctions
            </RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/contact">
              Contact
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/login">
              Login
            </RouterLink>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>