import GlobalStyle from "./styles/global";
import styled from "styled-components";
import Form from "./components/form";
import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const Container = styled.div`
  width: 100%;
  max-width: 800px;
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  align-itens: center;
  gap: 10px;
`;

const Title = styled.h2``;

function App() {
  return (
    <>
    <Container>
        <Title>USUÁRIOS</Title>
        <Form />
    </Container>
    <ToastContainer autoClose={3000} position={toast.POSITION.BOTTOM_LEFT} />
    <GlobalStyle />
    </>
  );
}

export default App;
