import axios from 'axios';
import { useState } from 'preact/hooks';
import Input from '../components/input';
import Result from '../components/result';

const App = () => {
	const [url, setUrl] = useState('');
	const [result, setResult] = useState();
	const [loading, setLoading] = useState(false);

	function handleInput(e) {
		setUrl(e.target.value);
	}
  
	function handleSubmit(e) {
		e.preventDefault();
		setLoading(true);

		// TODO: auto paste on clipboard link

		axios
			.post('/api', { url })
			.then(({ data }) => {
				setLoading(false);
				setResult(state => ({ ...state, ...data }));
			})
			.catch(error => {
				console.error(error);
				setLoading(false);
				setResult(state => ({
					status: 'error',
					data: null
				}));
			});
	}

	return (
		<div>
			<div className="senja">
				<h1 className="logo">ｆｂｄｏｗｎ</h1>
				<div className="mount" />
			</div>

			<main>
				<Input submit={handleSubmit} input={handleInput} url={url} />
				<Result loading={loading} result={result} />
			</main>
			
		</div>
	);
};

export default App;
