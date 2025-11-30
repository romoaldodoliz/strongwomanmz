    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, var(--secondary-color) 0%, #000 100%); color: white; padding: 50px 0 30px; margin-top: 80px; border-top: 4px solid var(--primary-color);">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4 style="color: var(--primary-color); margin-bottom: 20px;">Strong Woman</h4>
                    <p><strong>Local:</strong> Maputo, Moçambique</p>
                    <p><strong>Telefone:</strong> <a href="tel:+25884768523" style="color: white; text-decoration: none;">(+258) 84768523</a></p>
                    <p><strong>Contacto:</strong> <a href="tel:+258828372810" style="color: white; text-decoration: none;">(+258) 828372810</a></p>
                    <p><strong>E-mail:</strong> <a href="mailto:palmira.mucavele@strongwoman-mz.org" style="color: white; text-decoration: none;">palmira.mucavele@strongwoman-mz.org</a></p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4 style="color: var(--primary-color); margin-bottom: 20px;">Links Rápidos</h4>
                    <p><a href="index.php" style="color: white; text-decoration: none; transition: color 0.3s;">Início</a></p>
                    <p><a href="quem-somos.php" style="color: white; text-decoration: none; transition: color 0.3s;">Quem Somos</a></p>
                    <p><a href="eventos.php" style="color: white; text-decoration: none; transition: color 0.3s;">Eventos</a></p>
                    <p><a href="movimentos.php" style="color: white; text-decoration: none; transition: color 0.3s;">Nossos Movimentos</a></p>
                    <p><a href="doacoes.php" style="color: white; text-decoration: none; transition: color 0.3s;">Doações</a></p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4 style="color: var(--primary-color); margin-bottom: 20px;">Redes Sociais</h4>
                    <p class="mb-3">Conecte-se connosco nas redes sociais</p>
                    <div class="d-flex gap-3">
                        <a href="#" style="color: white; font-size: 24px; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='white'"><i class="bi bi-twitter"></i></a>
                        <a href="#" style="color: white; font-size: 24px; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='white'"><i class="bi bi-facebook"></i></a>
                        <a href="#" style="color: white; font-size: 24px; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='white'"><i class="bi bi-instagram"></i></a>
                        <a href="#" style="color: white; font-size: 24px; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='white'"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 30px 0;">
            <div class="text-center">
                <p class="mb-2">&copy; 2023 - <?php echo date("Y"); ?>. Todos Direitos Reservados <strong>STRONG WOMAN</strong>.</p>
                <p class="mb-0"><a href="admin/" style="color: white; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='white'"><i class="bi bi-lock"></i> Admin</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (isset($include_swiper) && $include_swiper): ?>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <?php endif; ?>
</body>
</html>
